<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;
use App\Models\ArchitectProfile;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        if (! $user->isPremium()) {
            return redirect()->route('upgrade.index')
                ->with('upgrade_required', 'Upgrade ke Premium untuk mengakses dan mengedit Profil Publik arsitekmu.');
        }

        $profile = $user->architectProfile ?? new ArchitectProfile;
        $specializations = Specialization::all();
        $selectedSpecializations = $profile->exists ? $profile->specializations->pluck('id')->toArray() : [];
        $portfolios = $profile->exists ? $profile->portfolios()->latest()->get() : collect();

        return view('dashboard.architect.profile.edit', compact('user', 'profile', 'specializations', 'selectedSpecializations', 'portfolios'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->architectProfile ?? new ArchitectProfile(['user_id' => $user->id]);

        $validated = $request->validate([
            'price_per_m2' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
            'bank_accounts' => 'nullable|array',
            'bank_accounts.*.bank_name' => 'required_with:bank_accounts|string|max:255',
            'bank_accounts.*.account_number' => 'required_with:bank_accounts|string|max:255',
            'bank_accounts.*.account_holder' => 'required_with:bank_accounts|string|max:255',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'remove_qris' => 'nullable|boolean',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image && !str_starts_with($profile->profile_image, 'http')) {
                Storage::disk('public')->delete($profile->profile_image);
            }
            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload($request->file('profile_image')->getRealPath(), [
                'folder' => 'ruang_temu/profiles'
            ]);
            $validated['profile_image'] = $upload['secure_url'];
        }

        if ($request->boolean('remove_qris') && $profile->qris_image) {
            if (!str_starts_with($profile->qris_image, 'http')) {
                Storage::disk('public')->delete($profile->qris_image);
            }
            $validated['qris_image'] = null;
        } elseif ($request->hasFile('qris_image')) {
            if ($profile->qris_image && !str_starts_with($profile->qris_image, 'http')) {
                Storage::disk('public')->delete($profile->qris_image);
            }
            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload($request->file('qris_image')->getRealPath(), [
                'folder' => 'ruang_temu/qris'
            ]);
            $validated['qris_image'] = $upload['secure_url'];
        }

        $profile->fill($validated);
        $profile->save();

        if (isset($validated['specializations'])) {
            $profile->specializations()->sync($validated['specializations']);
        } else {
            $profile->specializations()->detach();
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function deactivate()
    {
        $user = auth()->user();
        $user->update(['is_active' => false]);

        Auth::logout();

        return redirect('/')->with('success', 'Akun berhasil dinonaktifkan.');
    }
}
