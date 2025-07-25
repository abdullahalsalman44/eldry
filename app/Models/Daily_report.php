<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily_report extends Model
{


    protected $fillable = [
        'elderly_id',
        'user_id',
        'mood',
        'sleep_quality',
        'appetite',
        'vital_signs',
        'notes',
        'report_date',
    ];
    public function elderly()
    {
        return $this->belongsTo(ElderlyPerson::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
