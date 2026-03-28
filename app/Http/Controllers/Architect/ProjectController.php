<?php

namespace App\Http\Controllers\Architect;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('user')
            ->where('architect_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('dashboard.architect.projects.index', compact('projects'));
    }

    public function updateStatus(Request $request, Project $project)
    {
        if ($project->architect_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,on_progress,completed',
        ]);

        $allowedTransitions = [
            'pending' => ['pending', 'paid'],
            'paid' => ['paid', 'on_progress'],
            'on_progress' => ['on_progress', 'completed'],
            'completed' => ['completed'],
        ];

        $currentStatus = $project->status;
        $nextStatus = $validated['status'];

        if (! in_array($nextStatus, $allowedTransitions[$currentStatus] ?? [], true)) {
            return back()->with('error', 'Status tidak valid. Alur harus: pending -> paid -> on_progress -> completed.');
        }

        $project->update(['status' => $validated['status']]);

        return back()->with('success', 'Status proyek berhasil diperbarui!');
    }
}
