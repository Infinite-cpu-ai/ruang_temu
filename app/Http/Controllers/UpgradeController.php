<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MidtransPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UpgradeController extends Controller
{
    private const PREMIUM_PRICE = 50000;

    public function index(MidtransPaymentService $midtrans): View
    {
        /** @var User $user */
        $user = auth()->user();

        $viewData = [
            'midtransReady' => $midtrans->hasCredentials(),
        ];

        if ($user?->role === 'architect') {
            return view('upgrade-architect', $viewData);
        }

        return view('upgrade', $viewData);
    }

    /**
     * Process upgrade to premium via Midtrans Snap.
     */
    public function process(Request $request, MidtransPaymentService $midtrans): View|RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->isPremium()) {
            return redirect()->route('dashboard')
                ->with('success', 'Kamu sudah Premium!');
        }

        // If Midtrans is not configured, simulate a successful payment (dev mode)
        if (! $midtrans->hasCredentials()) {
            $user->update([
                'is_premium' => true,
                'is_subscription_active' => true,
                'premium_expires_at' => now()->addMonth(),
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Selamat! Akun kamu sudah Premium 🎉');
        }

        try {
            $snapToken = $midtrans->createPremiumSnapToken($user, self::PREMIUM_PRICE);
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['payment' => 'Gagal menyiapkan pembayaran Midtrans. Coba lagi atau hubungi admin.']);
        }

        $viewName = $user->role === 'architect' ? 'upgrade-architect' : 'upgrade';

        return view($viewName, [
            'snapToken' => $snapToken,
            'snapClientKey' => config('midtrans.client_key'),
            'snapScriptUrl' => $midtrans->snapScriptUrl(),
            'midtransReady' => true,
        ]);
    }

    /**
     * Finish callback after Snap payment completed.
     */
    public function finish(Request $request): RedirectResponse
    {
        // Midtrans notification handler will update the user's premium status.
        // This is just a redirect for the user after the Snap popup closes.
        return redirect()->route('dashboard')
            ->with('success', 'Pembayaran sedang diproses. Status Premium akan aktif setelah pembayaran dikonfirmasi.');
    }

    /**
     * Cancel premium auto-renewal.
     */
    public function cancel(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->is_premium) {
            $user->update([
                'is_subscription_active' => false,
            ]);
        }

        return back()->with('success', 'Perpanjangan otomatis langganan Premium telah dibatalkan. Fitur Premium tetap aktif hingga akhir periode berjalan.');
    }
}
