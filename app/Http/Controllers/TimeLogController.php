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
            // Set end time first
            $log->end_time = now();
            $log->save();

            // Calculate duration in seconds
            $seconds = $log->start_time->diffInSeconds($log->end_time);

            // Convert duration to coins (1 hour = 1 coin) while carrying leftover seconds
            $user = auth()->user();
            $totalSeconds = $user->coin_seconds_balance + $seconds;
            $coinsEarned = intdiv($totalSeconds, 3600); // floor division
            $user->coin_seconds_balance = $totalSeconds % 3600;

            if ($coinsEarned > 0) {
                $user->coins += $coinsEarned;
            }

            $user->save();
        }

        return back();
    }
}