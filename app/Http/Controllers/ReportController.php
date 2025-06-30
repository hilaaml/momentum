<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $projects = auth()->user()->projects()->with('tasks')->get();

        $from = Carbon::parse($request->input('from', now()->startOfMonth()))->startOfDay();
        $to   = Carbon::parse($request->input('to',   now()))->endOfDay();

        $timeLogs     = $user->logsBetween($from, $to);
        $totalSeconds = $user->totalSecondsBetween($from, $to);

        $daysCount = $from->diffInDays($to) + 1;
        $averagePerDay = $daysCount ? intdiv($totalSeconds, $daysCount) : 0;

        $dailyData = [];
        $byDay = $byHour = [];

        foreach ($timeLogs as $log) {
            $date     = $log->start_time->toDateString();
            $seconds  = $log->end_time->diffInSeconds($log->start_time);
            $dailyData[$date] = ($dailyData[$date] ?? 0) + $seconds;

            $dayName  = $log->start_time->isoFormat('dddd');
            $byDay[$dayName] = ($byDay[$dayName] ?? 0) + $seconds;

            for ($t = $log->start_time->copy(); $t < $log->end_time; $t->addHour()) {
                $hour = $t->format('H');
                $byHour[$hour] = ($byHour[$hour] ?? 0) + 3600;
            }
        }

        $mostActiveDay  = $byDay  ? array_keys($byDay,  max($byDay))[0]  : null;
        $mostActiveHour = $byHour ? array_keys($byHour, max($byHour))[0] : null;

        $projectTimes = $timeLogs->groupBy('project_id')->map(function ($logs) {
            return $logs->sum(function ($log) {
                return $log->end_time->diffInSeconds($log->start_time);
            });
        });

        $topProjectId = $projectTimes->sortDesc()->keys()->first();
        $topProject = $topProjectId ? \App\Models\Project::find($topProjectId) : null;
        $topProjectSeconds = $topProjectId ? $projectTimes[$topProjectId] : 0;

        $completedTasksCount = $user->projects
            ->flatMap->tasks
            ->filter(function ($task) use ($from, $to) {
                return $task->is_checked && $task->updated_at->between($from, $to);
            })
            ->count();

        $trackedProjectCount = $timeLogs->pluck('project_id')->unique()->count();

        $projectTimes = $timeLogs->groupBy('project_id')->map(function ($logs) {
            return $logs->sum(fn($log) => $log->end_time->diffInSeconds($log->start_time));
        });

        $projectLabels = [];
        $projectValues = [];

        foreach ($projectTimes as $projectId => $seconds) {
            $project = \App\Models\Project::find($projectId);
            if ($project) {
                $projectLabels[] = $project->name;
                $projectValues[] = $seconds;
            }
        }

        $allLogs = $projects->flatMap->all_logs
            ->filter(fn($log) => $log->start_time >= $from && $log->start_time <= $to)
            ->sortByDesc('start_time');

        return view('reports', compact(
            'from',
            'to',
            'totalSeconds',
            'averagePerDay',
            'dailyData',
            'mostActiveDay',
            'mostActiveHour',
            'topProject',
            'topProjectSeconds',
            'completedTasksCount',
            'trackedProjectCount',
            'projectLabels',
            'projectValues',
            'byDay',
            'byHour',
            'allLogs'
        ));
    }
}
