<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransPaymentService
{
    public function configure(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function hasCredentials(): bool
    {
        return filled(config('midtrans.server_key')) && filled(config('midtrans.client_key'));
    }

    public function snapScriptUrl(): string
    {
        return config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    /**
     * @throws \Exception
     */
    public function createSnapToken(Project $project, User $client, User $architect): string
    {
        $this->configure();

        $grossAmount = (int) round((float) $project->total_price);

        $params = [
            'transaction_details' => [
                'order_id' => $this->orderIdForProject($project),
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => Str::limit((string) $client->name, 40),
                'email' => $client->email,
            ],
            'item_details' => [
                [
                    'id' => 'project-'.$project->id,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => Str::limit('Desain — '.$project->property_type, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('checkout.finish', $project),
            ],
        ];

        return Snap::getSnapToken($params);
    }

    public function orderIdForProject(Project $project): string
    {
        return 'RUANGTEMU-P-'.$project->id;
    }

    public function projectIdFromOrderId(string $orderId): ?int
    {
        if (preg_match('/^RUANGTEMU-P-(\d+)$/', $orderId, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    /**
     * Create a Snap token for a premium subscription payment.
     *
     * @throws \Exception
     */
    public function createPremiumSnapToken(User $user, int $grossAmount): string
    {
        $this->configure();

        $orderId = $this->orderIdForPremium($user);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => Str::limit((string) $user->name, 40),
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => 'premium-'.$user->id,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => 'Ruang Temu Premium — 1 Bulan',
                ],
            ],
        ];

        return Snap::getSnapToken($params);
    }

    public function orderIdForPremium(User $user): string
    {
        return 'RUANGTEMU-PREM-'.$user->id.'-'.now()->timestamp;
    }

    public function userIdFromPremiumOrderId(string $orderId): ?int
    {
        if (preg_match('/^RUANGTEMU-PREM-(\d+)-\d+$/', $orderId, $matches)) {
            return (int) $matches[1];
        }

        return null;
    }

    public function isPremiumOrder(string $orderId): bool
    {
        return str_starts_with($orderId, 'RUANGTEMU-PREM-');
    }
}
