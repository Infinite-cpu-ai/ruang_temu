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
            'premium_expires_at' => now()->addMonth(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Selamat! Akun kamu sudah Premium 🎉');
    }
}
