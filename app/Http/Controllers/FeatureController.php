<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FeatureController extends Controller
{
    public function cari()
    {
        // For prototype, fetch users with 'architect' role
        $architects = User::where('role', 'architect')->with('architectProfile')->get();
        return view('features.cari', compact('architects'));
    }

    public function profil($id)
    {
        $architect = User::where('role', 'architect')->with('architectProfile')->findOrFail($id);
        return view('features.profil', compact('architect'));
    }

    public function pricing()
    {
        return view('features.pricing');
    }
}
