<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    public function toggle(Task $task)
    {
        // Pastikan hanya pemilik project yang bisa ubah task
        if ($task->project->user_id !== auth()->id()) {
            abort(403);
        }

        $task->is_done = !$task->is_done;
        $task->save();

        // Update user's coins based on task completion state
        $user = auth()->user();
        if ($task->is_done) {
            // Award 1 coin for completing a task
            $user->coins += 1;
        } else {
            // If task is marked as not done, remove the previously awarded coin (but not below zero)
            $user->coins = max(0, $user->coins - 1);
        }
        $user->save();

        return back();
    }
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
        ]);

        $project = Project::findOrFail($request->project_id);

        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $project->tasks()->create([
            'name' => $request->name,
        ]);

        return back();
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $request->validate(['name' => 'required|string|max:255']);
        $task->update(['name' => $request->name]);
        return redirect()->route('dashboard');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return back();
    }
}
