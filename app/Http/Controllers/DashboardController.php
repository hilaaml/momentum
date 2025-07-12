<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Carbon;
use App\Models\TimeLog;
use App\Models\Project;
use App\Models\Character;

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

        // Tampilkan view dashboard dengan data yang dibutuhkan
        return view('dashboard.index', compact(
            'projects',
            'totalTodayInSeconds',
            'todayLogs',
            'allLogs',
            'streak',
            'unlockedCharacters',
            'formattedTodayTime',
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
        return redirect()->route('dashboard');
    }
}
