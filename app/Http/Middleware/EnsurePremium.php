<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePremium
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = $request->user();

        if (! $user || ! $user->isPremium()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Fitur ini hanya untuk pengguna Premium.'], 403);
            }

            return redirect()->route('upgrade.index')
                ->with('upgrade_required', 'Fitur ini memerlukan akun Premium. Upgrade sekarang untuk akses penuh!');
        }

        return $next($request);
    }
}
