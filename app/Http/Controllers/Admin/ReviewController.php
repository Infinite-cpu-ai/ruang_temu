<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['client', 'architect', 'project'])
            ->orderBy('is_reported', 'desc')
            ->latest()
            ->paginate(15);

        return view('dashboard.admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }

    public function resolveReport(Review $review)
    {
        $review->update([
            'is_reported' => false,
            'report_reason' => null,
        ]);

        return back()->with('success', 'Laporan ulasan berhasil diselesaikan.');
    }
}
