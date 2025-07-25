<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication_schedule extends Model
{

    protected $fillable = [
        'medication_id',
        'caregiver_id',
        'date',
        'time',
        'status',
        'notes',
    ];
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id');
    }
}
