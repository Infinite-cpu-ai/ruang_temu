<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $architectId = Auth::id();

        $totalRevenue = Project::where('architect_id', $architectId)->where('status', 'completed')->sum('total_price');
        $activeProjects = Project::where('architect_id', $architectId)->whereIn('status', ['pending', 'in_progress'])->count();
        $completedProjects = Project::where('architect_id', $architectId)->where('status', 'completed')->count();
        $totalReviews = Review::where('architect_id', $architectId)->count();
        $avgRating = Review::where('architect_id', $architectId)->avg('rating') ?? 0;
        $followersCount = Auth::user()->followers()->count();
        $recentProjects = Project::where('architect_id', $architectId)
            ->with('client')
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard.architect.index', compact(
            'totalRevenue',
            'activeProjects',
            'completedProjects',
            'totalReviews',
            'avgRating',
            'followersCount',
            'recentProjects',
        ));
    }
}
