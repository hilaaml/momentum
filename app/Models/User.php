<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\TimeLog;
use Illuminate\Support\Collection;
use Carbon\CarbonInterval;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'streak_minimum_seconds',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function logsBetween(Carbon $from, Carbon $to)
    {
        return \App\Models\TimeLog::with('project')
            ->whereHas('project', fn($q) => $q->where('user_id', $this->id))
            ->whereBetween('start_time', [$from, $to])
            ->whereNotNull('end_time')
            ->orderByDesc('start_time')
            ->get();
    }

    public function totalSecondsBetween(Carbon $from, Carbon $to): int
    {
        // hitung di query – jauh lebih cepat & tidak tergantung cast
        return (int) \App\Models\TimeLog::whereHas('project', fn($q) =>
        $q->where('user_id', $this->id))
            ->whereBetween('start_time', [$from, $to])
            ->whereNotNull('end_time')
            ->selectRaw('COALESCE(SUM(TIMESTAMPDIFF(SECOND, start_time, end_time)),0) AS total')
            ->value('total');
    }


    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withTimestamps();
    }

    public function timeLogs()
    {
        return $this->hasManyThrough(
            \App\Models\TimeLog::class,
            \App\Models\Project::class,
            'user_id',     // foreign key di Project
            'project_id',  // foreign key di TimeLog
            'id',          // key User
            'id'           // key Project
        );
    }

    public function getStreakDays(): int
    {
        $minSeconds = $this->streak_minimum_seconds ?? 1; // default fallback

        // Ambil total durasi per hari 30 hari ke belakang
        $dailyDurations = $this->timeLogs()
            ->whereNotNull('end_time')
            ->whereDate('start_time', '>=', now()->subDays(30))
            ->selectRaw('DATE(start_time) as d, SUM(TIMESTAMPDIFF(SECOND, start_time, end_time)) as total')
            ->groupBy('d')
            ->orderByDesc('d')
            ->pluck('total', 'd');

        $streak = 0;
        $cursor = now()->startOfDay();

        for ($i = 0; $i < 30; $i++) {
            $date = $cursor->toDateString();
            $seconds = (int) ($dailyDurations[$date] ?? 0);

            if ($seconds >= $minSeconds) {
                $streak++;
                $cursor->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }


    // Total detik aktivitas hari ini
    public function getTodaySecondsAttribute(): int
    {
        return (int) $this->timeLogs()
            ->whereDate('start_time', now())
            ->selectRaw('COALESCE(SUM(IFNULL(TIMESTAMPDIFF(SECOND, start_time, end_time), TIMESTAMPDIFF(SECOND, start_time, NOW()))),0) AS sec')
            ->value('sec');
    }

    public function totalTrackedSeconds()
    {
        return \DB::table('projects')
            ->where('user_id', $this->id)
            ->sum('total_seconds');
    }
}
