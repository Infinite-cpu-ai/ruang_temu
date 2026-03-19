<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Step 1: Show Order Summary Form
    public function index($architectId)
    {
        // Get architect details for the summary
        $architect = User::where('role', 'architect')->findOrFail($architectId);
        
        return view('features.checkout', compact('architect'));
    }

    // Step 2: Form Submitted -> Generate Snap Token & Return to view to pay
    public function processPayment(Request $request)
    {
        $request->validate([
            'architect_id' => 'required|exists:users,id',
            'property_type' => 'required|string',
            'area_size' => 'required|numeric|min:10',
            'price_per_m2' => 'required|numeric',
        ]);

        $totalPrice = $request->area_size * $request->price_per_m2;

        // Create Project in Database
        $project = Project::create([
            'user_id' => Auth::id(),
            'architect_id' => $request->architect_id,
            'property_type' => $request->property_type,
            'area_size' => $request->area_size,
            'total_price' => $totalPrice,
            'status' => 'paid', // Langsung anggap paid untuk prototype tanpa Midtrans
        ]);

        $architect = User::find($request->architect_id);
        $paymentSuccess = true;

        // Return the view again dengan flag sukses
        return view('features.checkout', compact('architect', 'project', 'paymentSuccess'));
    }
}