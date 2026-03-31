<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowedArchitectController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if (! $user) {
            return view('features.followed', [
                'architects' => collect(),
                'isGuest' => true,
            ]);
        }

        $architects = $user->followingArchitects()
            ->where('role', 'architect')
            ->with('architectProfile')
            ->withAvg('reviewsAsArchitect as reviews_avg_rating', 'rating')
            ->get();

        return view('features.followed', [
            'architects' => $architects,
            'isGuest' => false,
        ]);
    }
}
