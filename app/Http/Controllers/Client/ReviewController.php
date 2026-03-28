<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = auth()->user()->reviewsAsClient()
            ->with('architect')
            ->latest()
            ->paginate(10);

        return view('dashboard.client.reviews.index', compact('reviews'));
    }

    public function create(Project $project)
    {
        if ($project->user_id !== auth()->id() || $project->status !== 'completed') {
            abort(403, 'Anda hanya bisa memberikan review untuk proyek yang sudah selesai.');
        }

        // Check if already reviewed
        if (Review::where('project_id', $project->id)->exists()) {
            return redirect()->route('client.reviews.index')->with('error', 'Anda sudah memberikan review untuk proyek ini.');
        }

        return view('dashboard.client.reviews.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id() || $project->status !== 'completed') {
            abort(403);
        }
        if (Review::where('project_id', $project->id)->exists()) {
            abort(403, 'Review exist');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'project_id' => $project->id,
            'client_id' => auth()->id(),
            'architect_id' => $project->architect_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('client.reviews.index')->with('success', 'Review berhasil dikirim.');
    }

    public function edit(Review $review)
    {
        if ($review->client_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.client.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->client_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->route('client.reviews.index')->with('success', 'Review berhasil diperbarui.');
    }
}
