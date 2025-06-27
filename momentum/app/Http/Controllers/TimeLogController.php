<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\TimeLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeLogController extends Controller
{
    public function start(Project $project)
    {
        $userId = auth()->id();
        abort_if($project->user_id !== $userId, 403);

        // Hentikan log lain yang masih aktif
        TimeLog::whereHas('project', fn($q) => $q->where('user_id', $userId))
            ->whereNull('end_time')
            ->update(['end_time' => now()]);

        // Buat log baru
        TimeLog::create([
            'project_id' => $project->id,
            'start_time' => now(),
        ]);

        return back();
    }

    public function stop(Project $project)
    {
        $log = $project->timeLogs()
            ->whereNull('end_time')
            ->latest('start_time')
            ->first();

        if ($log) {
            $log->update(['end_time' => now()]);
        }

        return back();
    }
}