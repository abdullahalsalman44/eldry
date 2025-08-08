<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ElderlyPerson extends Model
{

    protected $fillable = [
        'full_name',
        'date_of_birth',
        'gender',
        'room_id',
        'image',
        'login_at',
        'caregiver_id'
    ];


    protected static function booted(): void
    {
        static::saved(function ($elderly) {
            if ($elderly->room) {
                $elderly->room->updateStatusBasedOnOccupancy();
            }
        });

        static::deleted(function ($elderly) {
            if ($elderly->room) {
                $elderly->room->updateStatusBasedOnOccupancy();
            }
        });
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'elderly_user');
    // }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caregiver_id');
    }

    public function dailyReports()
    {
        return $this->hasMany(Daily_report::class, 'elderly_id');
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function medicalNotes()
    {
        return $this->hasMany(Medical_note::class);
    }

    public function emergencyEvents()
    {
        return $this->hasMany(Emergency_event::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'elderly_id');
    }
}
