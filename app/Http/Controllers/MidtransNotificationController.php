<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Midtrans\Config;
use Midtrans\Transaction;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request, MidtransPaymentService $midtransPayment): Response
    {
        if (! $midtransPayment->hasCredentials()) {
            return response('MIDTRANS_NOT_CONFIGURED', 503);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $raw = json_decode($request->getContent(), true);
        if (! is_array($raw) || empty($raw['order_id'])) {
            return response('INVALID_JSON', 400);
        }

        $orderId = (string) $raw['order_id'];
        $projectId = $midtransPayment->projectIdFromOrderId($orderId);
        if ($projectId === null) {
            return response('UNKNOWN_ORDER', 404);
        }

        $project = Project::query()->find($projectId);
        if (! $project) {
            return response('PROJECT_NOT_FOUND', 404);
        }

        try {
            $statusPayload = Transaction::status($orderId);
        } catch (\Throwable $e) {
            report($e);

            return response('STATUS_LOOKUP_FAILED', 502);
        }

        $transactionStatus = data_get($statusPayload, 'transaction_status');
        $fraudStatus = data_get($statusPayload, 'fraud_status');
        $paymentType = data_get($statusPayload, 'payment_type');

        $shouldMarkPaid = false;

        if ($transactionStatus === 'settlement') {
            $shouldMarkPaid = true;
        } elseif ($transactionStatus === 'capture') {
            if ($paymentType === 'credit_card' && $fraudStatus === 'challenge') {
                $shouldMarkPaid = false;
            } else {
                $shouldMarkPaid = true;
            }
        }

        if ($shouldMarkPaid && $project->status !== 'paid') {
            $project->forceFill(['status' => 'paid'])->save();
        }

        return response('OK', 200);
    }
}
