<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'duration'];

    /* -----------------------------------------------------------------
     | RELATIONS
     |-----------------------------------------------------------------*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function timeLogs()
    {
        return $this->hasMany(TimeLog::class);
    }

    /* -----------------------------------------------------------------
     | TIMELINE COLLECTIONS
     |-----------------------------------------------------------------*/

    /** Semua log proyek (terbaru → terlama) */
    public function getAllLogsAttribute()
    {
        return $this->timeLogs()
            ->orderByDesc('start_time')
            ->get();
    }

    /** Log khusus hari ini */
    public function getTodayLogsAttribute()
    {
        return $this->timeLogs()
            ->whereDate('start_time', Carbon::today())
            ->orderByDesc('start_time')
            ->get();
    }

    /* -----------------------------------------------------------------
     | DAILY DURATION (timer utama)
     |-----------------------------------------------------------------*/
    public function getTodaySecondsAttribute(): int
    {
        return $this->today_logs
            ->reduce(
                fn($c, $log) =>
                $c + ($log->end_time ?? now())->diffInSeconds($log->start_time),
                0
            );
    }

    public function getTodayTimeAttribute(): string
    {
        return CarbonInterval::seconds($this->today_seconds)
            ->cascade()->format('%H:%I:%S');
    }

    /* -----------------------------------------------------------------
     | STATUS
     |-----------------------------------------------------------------*/
    public function getIsActiveAttribute(): bool
    {
        return $this->timeLogs()->whereNull('end_time')->exists();
    }

    /* -----------------------------------------------------------------
     | TOTAL DURATION (sepanjang masa)
     |-----------------------------------------------------------------*/
    public function getTotalSecondsAttribute(): int
    {
        // detik log yang sudah selesai
        $finished = $this->timeLogs()
            ->whereNotNull('end_time')
            ->get()                                 // ← collection
            ->sum(fn($l) => $l->end_time->diffInSeconds($l->start_time));

        // tambah detik log aktif (jika ada)
        if ($this->is_active) {
            $activeStart = $this->timeLogs()
                ->whereNull('end_time')
                ->latest('start_time')
                ->value('start_time');

            $finished += $activeStart ? now()->diffInSeconds($activeStart) : 0;
        }

        return $finished;
    }

    /** Total durasi terformat (HH:MM:SS) */
    public function getTotalDurationAttribute(): string
    {
        return CarbonInterval::seconds($this->total_seconds)
            ->cascade()->format('%H:%I:%S');
    }
}
