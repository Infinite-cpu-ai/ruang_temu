<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalProjects = Project::where('user_id', $user->id)->count();
        $activeProjects = Project::where('user_id', $user->id)->whereIn('status', ['pending', 'in_progress'])->count();
        $completedProjects = Project::where('user_id', $user->id)->where('status', 'completed')->count();
        $reviewsGiven = Review::where('client_id', $user->id)->count();
        $followingCount = $user->followingArchitects()->count();
        $recentProjects = Project::where('user_id', $user->id)
            ->with('architect')
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard.client.index', compact(
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'reviewsGiven',
            'followingCount',
            'recentProjects',
        ));
    }
}
