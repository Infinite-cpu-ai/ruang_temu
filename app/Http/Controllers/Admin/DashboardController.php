<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalArchitects = User::where('role', 'architect')->count();
        $totalProjects = Project::count();
        $totalRevenue = Project::where('status', 'completed')->sum('total_price');
        $totalReviews = Review::count();
        $reportedReviews = Review::where('is_reported', true)->count();

        return view('dashboard.admin.index', compact(
            'totalUsers',
            'totalArchitects',
            'totalProjects',
            'totalRevenue',
            'totalReviews',
            'reportedReviews',
        ));
    }
}
