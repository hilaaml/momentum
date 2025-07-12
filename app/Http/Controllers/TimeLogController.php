<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\TimeLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeLogController extends Controller
{
    // Mulai timer untuk sebuah project
    public function start(Project $project)
    {
        $userId = auth()->id();

        // Pastikan project milik user
        abort_if($project->user_id !== $userId, 403);

        // Hentikan semua log aktif milik user lain
        TimeLog::whereHas('project', fn($q) => $q->where('user_id', $userId))
            ->whereNull('end_time')
            ->update(['end_time' => now()]);

        // Buat time log baru
        TimeLog::create([
            'project_id' => $project->id,
            'start_time' => now(),
        ]);

        return back();
    }

    // Hentikan timer aktif pada project
    public function stop(Project $project)
    {
        // Ambil log aktif terakhir
        $log = $project->timeLogs()
            ->whereNull('end_time')
            ->latest('start_time')
            ->first();

        if ($log) {
            // Simpan waktu selesai log
            $log->end_time = now();
            $log->save();

            // Hitung durasi dalam detik
            $seconds = $log->start_time->diffInSeconds($log->end_time);

            $user = auth()->user();

            // Tambahkan ke saldo detik coin user
            $totalSeconds = $user->coin_seconds_balance + $seconds;

            // Hitung coin yang didapat (1 coin per jam)
            $coinsEarned = intdiv($totalSeconds, 3600);

            // Simpan sisa detik sebagai saldo
            $user->coin_seconds_balance = $totalSeconds % 3600;

            // Tambahkan coin jika ada
            if ($coinsEarned > 0) {
                $user->coins += $coinsEarned;
            }

            $user->save();
        }

        return back();
    }
}
