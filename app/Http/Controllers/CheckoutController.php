<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessCheckoutRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(User $architect): View
    {
        if ($architect->role !== 'architect' || ! $architect->is_active) {
            abort(404);
        }

        $architect->load('architectProfile');

        $defaultPricePerM2 = (float) data_get($architect->architectProfile, 'price_per_m2', 0);
        if ($defaultPricePerM2 <= 0) {
            $defaultPricePerM2 = 150000;
        }

        return view('features.checkout', [
            'architect' => $architect,
            'defaultPricePerM2' => $defaultPricePerM2,
        ]);
    }

    public function processPayment(ProcessCheckoutRequest $request)
    {
        $area = (float) $request->validated('area_size');
        $pricePerM2 = (float) $request->validated('price_per_m2');
        $totalPrice = round($area * $pricePerM2, 2);

        $project = Project::create([
            'user_id' => Auth::id(),
            'architect_id' => $request->validated('architect_id'),
            'property_type' => $request->propertyTypeLabel(),
            'area_size' => (int) round($area),
            'price_per_m2' => $pricePerM2,
            'total_price' => $totalPrice,
            'status' => 'paid',
        ]);

        $architect = User::query()->with('architectProfile')->findOrFail($request->validated('architect_id'));
        $paymentSuccess = true;

        return view('features.checkout', [
            'architect' => $architect,
            'defaultPricePerM2' => (float) data_get($architect->architectProfile, 'price_per_m2', $pricePerM2),
            'project' => $project,
            'paymentSuccess' => $paymentSuccess,
        ]);
    }
}
