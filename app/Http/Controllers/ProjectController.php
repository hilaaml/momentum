<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tasks' => 'array',
            'tasks.*' => 'nullable|string|max:255',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        if ($request->has('tasks')) {
            foreach ($request->tasks as $taskName) {
                if ($taskName) {
                    Task::create([
                        'project_id' => $project->id,
                        'name' => $taskName,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Project berhasil dibuat.');
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $request->validate(['name' => 'required|string|max:255']);
        $project->update(['name' => $request->name]);

        return redirect()->route('dashboard');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return back();
    }
}
