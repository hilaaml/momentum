<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeLog;
use App\Models\Project;
use App\Models\Challenge;
use App\Models\Character;
use Illuminate\Support\Facades\DB;
use App\Models\ChallengeTask;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil semua project milik user beserta task-nya
        $projects = $user->projects()->with('tasks')->get();

        // Hitung total waktu kerja hari ini (dalam detik)
        $totalTodayInSeconds = $projects->sum->today_seconds;

        // Ambil log hari ini dari semua project
        $todayLogs = $projects->flatMap->today_logs;

        // Ambil semua log dari semua project dan urutkan dari terbaru
        $allLogs = $projects->flatMap->all_logs->sortByDesc('start_time');

        // Tampilan Timer
        $formattedTodayTime = \Carbon\CarbonInterval::seconds($totalTodayInSeconds)
            ->cascade()
            ->format('%H:%I:%S');

        // Hitung streak harian user
        $streak = $user->getStreakDays();

        // Hitung total waktu kerja keseluruhan
        $totalWorkInSeconds = $projects->sum('total_seconds');

        // Ambil semua karakter dari database
        $characters = Character::all();

        // Unlock karakter jika total waktu kerja memenuhi syarat
        foreach ($characters as $character) {
            if (
                $totalWorkInSeconds >= $character->required_seconds &&
                !$user->characters->contains($character->id)
            ) {
                $user->characters()->attach($character->id);
            }
        }

        // Ambil karakter yang sudah di-unlock user
        $unlockedCharacters = $user->characters;

        // Challenge yang diikuti
        $joinedChallengeIds = DB::table('challenge_user')
            ->where('user_id', $user->id)
            ->pluck('challenge_id');

        $joinedChallenges = Challenge::whereIn('id', $joinedChallengeIds)->get();

        $today = Carbon::today();
        $joinedChallenges = Challenge::whereIn('id', $joinedChallengeIds)->get();

        $challengesWithProgress = $joinedChallenges->map(function ($challenge) use ($user, $today) {
            $taskToday = ChallengeTask::where('challenge_id', $challenge->id)
                ->where('user_id', $user->id)
                ->whereDate('date', $today)
                ->first();

            $completedToday = false;

            if ($challenge->type === 'task') {
                $completedToday = $taskToday && $taskToday->proof_image && trim($taskToday->proof_image) !== '';
            } elseif ($challenge->type === 'time') {
                $completedToday = $taskToday?->is_completed ?? false;
            }

            $hasUploadedProof = $taskToday && $taskToday->proof_image && trim($taskToday->proof_image) !== '';

            $startDate = DB::table('challenge_user')
                ->where('challenge_id', $challenge->id)
                ->where('user_id', $user->id)
                ->value('joined_at');

            $diffDays = Carbon::parse($startDate)->diffInDays($today);
            $streak = ChallengeTask::where('challenge_id', $challenge->id)
                ->where('user_id', $user->id)
                ->where('is_completed', true)
                ->orderByDesc('date')
                ->take($challenge->target_days)
                ->get()
                ->reduce(function ($carry, $task) use ($today) {
                    $expectedDate = $today->copy()->subDays($carry);
                    return $task->date->isSameDay($expectedDate) ? $carry + 1 : $carry;
                }, 0);

            // Untuk time challenge, hitung remaining menit hari ini
            $remainingMinutesToday = null;
            if ($challenge->type === 'time') {
                $totalSeconds = TimeLog::whereHas('project', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                    ->whereDate('start_time', $today)
                    ->get()
                    ->sum(function ($log) {
                        return Carbon::parse($log->end_time)->diffInSeconds(Carbon::parse($log->start_time));
                    });

                $remainingMinutesToday = max(0, ceil(($challenge->target_seconds - $totalSeconds) / 60));
            }

            $challenge->streak = $streak;
            $challenge->days_remaining = max(0, $challenge->target_days - $diffDays);
            $challenge->is_completed_today = $completedToday;
            $challenge->has_uploaded_proof_today = $hasUploadedProof;
            $challenge->remaining_minutes_today = $remainingMinutesToday;

            return $challenge;
        });

        // Tampilkan view dashboard dengan data yang dibutuhkan
        return view('dashboard.index', compact(
            'projects',
            'totalTodayInSeconds',
            'todayLogs',
            'allLogs',
            'streak',
            'unlockedCharacters',
            'formattedTodayTime',

            'joinedChallenges',
            'challengesWithProgress'
        ));
    }

    public function updateStreakConfig(Request $request)
    {
        // Validasi input minimal waktu streak dalam menit
        $request->validate([
            'streak_minute_input' => 'required|integer|min:1',
        ]);

        // Simpan konfigurasi streak ke profil user
        $user = auth()->user();
        $user->streak_minimum_seconds = $request->streak_minute_input * 60;
        $user->save();

        // Redirect kembali ke dashboard
        return redirect()->route('dashboard')->with('success', 'Streak configuration updated successfully.');
    }
}
