<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessCheckoutRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\MidtransPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(User $architect, MidtransPaymentService $midtrans): View|RedirectResponse
    {
        if ($architect->role !== 'architect' || ! $architect->is_active) {
            return redirect()->route('features.cari')->with('error', 'Mohon maaf, profil Arsitek belum lengkap atau pengguna tersebut bukan Arsitek.');
        }

        $architect->load('architectProfile');

        $defaultPricePerM2 = (float) data_get($architect->architectProfile, 'price_per_m2', 0);
        if ($defaultPricePerM2 <= 0) {
            $defaultPricePerM2 = 150000;
        }

        return view('features.checkout', [
            'architect' => $architect,
            'defaultPricePerM2' => $defaultPricePerM2,
            'midtransReady' => $midtrans->hasCredentials(),
        ]);
    }

    public function processPayment(ProcessCheckoutRequest $request, MidtransPaymentService $midtrans): View|RedirectResponse
    {
        $area = (float) $request->validated('area_size');
        $units = (int) $request->validated('units');
        $pricePerM2 = (float) $request->validated('price_per_m2');
        $totalPrice = round($area * $pricePerM2 * $units, 2);

        $architect = User::query()->with('architectProfile')->findOrFail($request->validated('architect_id'));

        $project = Project::create([
            'user_id' => Auth::id(),
            'architect_id' => $request->validated('architect_id'),
            'property_type' => $request->propertyTypeLabel(),
            'area_size' => (int) round($area),
            'units' => $units,
            'price_per_m2' => $pricePerM2,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // If Midtrans is not configured, we simulate a successful payment automatically.
        if (! $midtrans->hasCredentials()) {
            $project->forceFill(['snap_token' => 'dummy', 'status' => 'paid'])->save();
            return redirect()->route('checkout.finish', $project);
        }

        try {
            $snapToken = $midtrans->createSnapToken($project, Auth::user(), $architect);
        } catch (\Throwable $e) {
            report($e);
            $project->delete();

            return back()
                ->withErrors(['payment' => 'Gagal menyiapkan pembayaran Midtrans. Coba lagi atau hubungi admin.'])
                ->withInput();
        }

        $project->forceFill(['snap_token' => $snapToken])->save();

        $defaultPricePerM2 = (float) data_get($architect->architectProfile, 'price_per_m2', $pricePerM2);
        if ($defaultPricePerM2 <= 0) {
            $defaultPricePerM2 = 150000;
        }

        return view('features.checkout', [
            'architect' => $architect,
            'defaultPricePerM2' => $defaultPricePerM2,
            'project' => $project,
            'snapToken' => $snapToken,
            'snapClientKey' => config('midtrans.client_key'),
            'snapScriptUrl' => $midtrans->snapScriptUrl(),
            'midtransReady' => true,
        ]);
    }

    public function finish(Request $request, Project $project, MidtransPaymentService $midtrans): View
    {
        if ((int) $project->user_id !== (int) $request->user()->id) {
            abort(403);
        }

        // If project is still pending and Midtrans is configured, poll the real status
        if ($project->status === 'pending' && $midtrans->hasCredentials() && $project->snap_token && $project->snap_token !== 'dummy') {
            try {
                $orderId = $midtrans->orderIdForProject($project);

                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');

                $statusPayload = \Midtrans\Transaction::status($orderId);
                $transactionStatus = data_get($statusPayload, 'transaction_status');
                $fraudStatus = data_get($statusPayload, 'fraud_status');
                $paymentType = data_get($statusPayload, 'payment_type');

                $shouldMarkPaid = false;
                if ($transactionStatus === 'settlement') {
                    $shouldMarkPaid = true;
                } elseif ($transactionStatus === 'capture') {
                    $shouldMarkPaid = ($paymentType !== 'credit_card' || $fraudStatus !== 'challenge');
                }

                if ($shouldMarkPaid) {
                    $project->forceFill(['status' => 'paid'])->save();
                }
            } catch (\Throwable $e) {
                // Silently fail — status will stay pending until webhook or next reload
                report($e);
            }
        }

        $architect = User::query()->with('architectProfile')->findOrFail($project->architect_id);

        $defaultPricePerM2 = (float) data_get($architect->architectProfile, 'price_per_m2', 0);
        if ($defaultPricePerM2 <= 0) {
            $defaultPricePerM2 = 150000;
        }

        return view('features.checkout', [
            'architect' => $architect,
            'defaultPricePerM2' => $defaultPricePerM2,
            'project' => $project,
            'paymentSuccess' => $project->status === 'paid',
            'paymentPending' => $project->status === 'pending',
            'midtransReady' => $midtrans->hasCredentials(),
        ]);
    }
}
