<?php

namespace App\Models;

use App\Enums\ApetitieEnum;
use App\Enums\HealthEnum;
use App\Enums\MoodEnum;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'apetitie',
        'mood',
        'health',
        'sleep_rate',
        'eldery_id',
        'caregiver_id'
    ];

    protected $casts = [
        'mood' => MoodEnum::class,
        'health' => HealthEnum::class,
        'apetitie' => ApetitieEnum::class,
    ];
}
