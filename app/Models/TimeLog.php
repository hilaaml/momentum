<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = ['project_id', 'start_time', 'end_time'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeForUserBetween($q, User $user, Carbon $from, Carbon $to)
    {
        return $q->whereHas('project', fn($p) => $p->where('user_id', $user->id))
            ->whereBetween('start_time', [$from->startOfDay(), $to->endOfDay()])
            ->whereNotNull('end_time');
    }
}
