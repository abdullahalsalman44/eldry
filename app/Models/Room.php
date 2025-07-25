<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $fillable = [
        'number',
        'capacity',
        'status',
    ];

    public function updateStatusBasedOnOccupancy(): void
    {
        $count = $this->elderlyPeople()->count();
        $this->status = $count >= $this->capacity ? 'occupied' : 'available';
        $this->saveQuietly();
    }


    public function elderlyPeople()
    {
        return $this->hasMany(ElderlyPerson::class);
    }
}
