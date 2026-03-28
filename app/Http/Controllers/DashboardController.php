<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'architect') {
            return redirect()->route('architect.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }
}
