<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{

    protected $fillable = [
        'elderly_id',
        'name',
        'dosage',
        'instructions',
    ];
    public function elderly()
    {
        return $this->belongsTo(ElderlyPerson::class);
    }

    public function schedules()
    {
        return $this->hasMany(Medication_schedule::class);
    }
}
