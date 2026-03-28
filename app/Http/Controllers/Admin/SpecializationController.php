<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::latest()->paginate(10);

        return view('dashboard.admin.specializations.index', compact('specializations'));
    }

    public function create()
    {
        return view('dashboard.admin.specializations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:specializations',
            'description' => 'nullable|string',
        ]);

        Specialization::create($validated);

        return redirect()->route('admin.specializations.index')->with('success', 'Spesialisasi berhasil ditambahkan.');
    }

    public function edit(Specialization $specialization)
    {
        return view('dashboard.admin.specializations.edit', compact('specialization'));
    }

    public function update(Request $request, Specialization $specialization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:specializations,name,'.$specialization->id,
            'description' => 'nullable|string',
        ]);

        $specialization->update($validated);

        return redirect()->route('admin.specializations.index')->with('success', 'Spesialisasi berhasil diperbarui.');
    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();

        return redirect()->route('admin.specializations.index')->with('success', 'Spesialisasi berhasil dihapus.');
    }
}
