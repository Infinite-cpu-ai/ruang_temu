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
