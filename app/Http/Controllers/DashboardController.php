<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Carbon;
use App\Models\TimeLog;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = auth()->user()->projects()->with('tasks')->get();
        $totalTodayInSeconds = $projects->sum->today_seconds;
        $todayLogs = $projects->flatMap->today_logs;
        $allLogs = $projects->flatMap->all_logs->sortByDesc('start_time');
        $streak = $user->getStreakDays();


        return view('dashboard.index', compact(
            'projects',
            'totalTodayInSeconds',
            'todayLogs',
            'allLogs',
            'streak',
        ));
    }
}
