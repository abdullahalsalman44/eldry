<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{

    protected $fillable = [
        'elderly_id',
        'caregiver_id',
        'date',
        'meal_type',
        'status',
        'served_at',
        'notes',
    ];
    public function elderly()
    {
        return $this->belongsTo(ElderlyPerson::class);
    }

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id');
    }
}
