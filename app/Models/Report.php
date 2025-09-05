<?php

namespace App\Models;

use App\Enums\ApetitieEnum;
use App\Enums\HealthEnum;
use App\Enums\MoodEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function eldery(): BelongsTo
    {
        return $this->belongsTo(ElderlyPerson::class, 'eldery_id');
    }
}
