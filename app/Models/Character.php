<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image_path', 'required_seconds'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
