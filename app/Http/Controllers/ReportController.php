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

        $from = Carbon::parse($request->input('from', now()->startOfMonth()))->startOfDay();
        $to   = Carbon::parse($request->input('to',   now()))->endOfDay();

        $timeLogs     = $user->logsBetween($from, $to);
        $totalSeconds = $user->totalSecondsBetween($from, $to);

        // ======= proses statistik ringan =======
        $daysCount = $from->diffInDays($to) + 1;   // inklusif
        $averagePerDay = $daysCount ? intdiv($totalSeconds, $daysCount) : 0;


        // heatmap & hari/jam aktif
        $dailyData = [];
        $byDay = $byHour = [];

        foreach ($timeLogs as $log) {
            $date     = $log->start_time->toDateString();
            $seconds  = $log->end_time->diffInSeconds($log->start_time);
            $dailyData[$date] = ($dailyData[$date] ?? 0) + $seconds;

            $dayName  = $log->start_time->locale('id')->isoFormat('dddd');
            $byDay[$dayName] = ($byDay[$dayName] ?? 0) + $seconds;

            for ($t = $log->start_time->copy(); $t < $log->end_time; $t->addHour()) {
                $hour = $t->format('H');
                $byHour[$hour] = ($byHour[$hour] ?? 0) + 3600;
            }
        }

        $mostActiveDay  = $byDay  ? array_keys($byDay,  max($byDay))[0]  : null;
        $mostActiveHour = $byHour ? array_keys($byHour, max($byHour))[0] : null;

        return view('reports', compact(
            'from',
            'to',
            'totalSeconds',
            'averagePerDay',
            'dailyData',
            'mostActiveDay',
            'mostActiveHour'
        ));
    }
}
