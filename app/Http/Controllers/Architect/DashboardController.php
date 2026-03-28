<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $architectId = auth()->id();

        $totalRevenue = Project::where('architect_id', $architectId)
            ->where('status', 'completed')
            ->sum('total_price');

        return view('dashboard.architect.index', compact('totalRevenue'));
    }
}
