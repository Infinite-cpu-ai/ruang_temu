<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->architectProfile;

        if (! $profile) {
            return redirect()->route('architect.profile.edit')->with('error', 'Harap lengkapi profil Anda terlebih dahulu sebelum menambah portofolio.');
        }

        $portfolios = $profile->portfolios()->latest()->paginate(10);

        return view('dashboard.architect.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('dashboard.architect.portfolios.create');
    }

    public function store(Request $request)
    {
        $profile = auth()->user()->architectProfile;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120', // 5MB Max
        ]);

        $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
        $upload = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath(), [
            'folder' => 'ruang_temu/portfolios'
        ]);
        $validated['image'] = $upload['secure_url'];

        $profile->portfolios()->create($validated);

        return redirect()->route('architect.portfolios.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio)
    {
        // Pastikan hanya pemilik yang bisa akses
        if ($portfolio->architect_profile_id !== auth()->user()->architectProfile->id) {
            abort(403);
        }

        return view('dashboard.architect.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        if ($portfolio->architect_profile_id !== auth()->user()->architectProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($portfolio->image && !str_starts_with($portfolio->image, 'http')) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $cloudinary = new \Cloudinary\Cloudinary(env('CLOUDINARY_URL'));
            $upload = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath(), [
                'folder' => 'ruang_temu/portfolios'
            ]);
            $validated['image'] = $upload['secure_url'];
        }

        $portfolio->update($validated);

        return redirect()->route('architect.portfolios.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->architect_profile_id !== auth()->user()->architectProfile->id) {
            abort(403);
        }

        if ($portfolio->image && !str_starts_with($portfolio->image, 'http')) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('architect.portfolios.index')->with('success', 'Portofolio berhasil dihapus.');
    }
}
