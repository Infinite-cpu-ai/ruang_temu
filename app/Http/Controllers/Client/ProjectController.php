<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('architect')
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->has('status') && in_array($request->status, ['pending', 'paid', 'on_progress', 'completed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        $projects = $query->paginate(10);

        return view('dashboard.client.projects.index', compact('projects'));
    }
}
