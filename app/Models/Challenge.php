<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'type',
        'target_seconds',
        'target_days',
    ];

    /**
     * Creator of the challenge.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Users who joined this challenge.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'challenge_user', 'challenge_id', 'user_id')
            ->withPivot(['joined_at'])
            ->withTimestamps();
    }

    /**
     * (Opsional) Jika kamu bikin model `ChallengeTask`, bisa dihubungkan:
     */
    public function tasks()
    {
        return $this->hasMany(ChallengeTask::class);
    }
}
