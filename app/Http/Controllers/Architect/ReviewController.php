<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = auth()->user()->reviewsAsArchitect()
            ->with(['client', 'project'])
            ->latest()
            ->paginate(15);

        return view('dashboard.architect.reviews.index', compact('reviews'));
    }
}
