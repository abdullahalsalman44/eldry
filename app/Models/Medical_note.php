<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medical_note extends Model
{

    protected $fillable = [
        'elderly_id',
        'doctor_id',
        'note',
        'is_critical',
    ];

    public function elderly()
    {
        return $this->belongsTo(ElderlyPerson::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
