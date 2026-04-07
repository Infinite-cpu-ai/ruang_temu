<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UpgradeController extends Controller
{
    public function index(): View
    {
        return view('upgrade');
    }

    /**
     * Process upgrade to premium (dummy — replace with Midtrans later).
     */
    public function process(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->update([
            'is_premium' => true,
            'is_subscription_active' => true,
            'premium_expires_at' => now()->addMonth(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Selamat! Akun kamu sudah Premium 🎉');
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
