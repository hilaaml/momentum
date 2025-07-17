<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Challenge;
use App\Models\ChallengeTask;
use App\Models\TimeLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckChallengeProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-challenge-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check daily challenge progress for all users';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Ambil semua challenge yang masih aktif
        $activeChallenges = DB::table('challenge_user')->get();

        foreach ($activeChallenges as $entry) {
            $challenge = Challenge::find($entry->challenge_id);

            if (!$challenge) continue;

            $startDate = Carbon::parse($entry->joined_at);
            $diffDays = $today->diffInDays($startDate);

            if ($diffDays >= $challenge->target_days) continue;

            // Cek jika sudah ada task hari ini
            $task = ChallengeTask::firstOrCreate([
                'challenge_id' => $challenge->id,
                'user_id' => $entry->user_id,
                'date' => $today,
            ]);

            // Jika sudah selesai, skip
            if ($task->is_completed) continue;

            if ($challenge->type === 'time') {
                // Hitung total durasi dari time logs hari ini
                $totalSeconds = TimeLog::whereHas('project', function ($q) use ($entry) {
                    $q->where('user_id', $entry->user_id);
                })
                    ->whereDate('start_time', $today)
                    ->get()
                    ->sum(function ($log) {
                        return Carbon::parse($log->end_time)->diffInSeconds(Carbon::parse($log->start_time));
                    });

                if ($totalSeconds >= $challenge->target_seconds) {
                    $task->is_completed = true;
                    $task->save();
                }
            }
        }

        $this->info('Challenge progress checked.');
    }
}
