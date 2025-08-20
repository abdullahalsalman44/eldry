<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use  HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'active',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    // public function elderlyPeople()
    // {
    //     return $this->belongsToMany(ElderlyPerson::class, 'elderly_user', 'user_id', 'elderly_id');
    // }

    public function elderlyPeople(): HasMany
    {
        return $this->hasMany(ElderlyPerson::class, 'caregiver_id');
    }

    public function reports()
    {
        return $this->hasMany(Daily_report::class);
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class, 'caregiver_id');
    }

    public function medicationSchedules()
    {
        return $this->hasMany(Medication_schedule::class, 'caregiver_id');
    }
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function emergencyEvents()
    {
        return $this->hasMany(Emergency_event::class, 'triggered_by');
    }

    public function medicalNotes()
    {
        return $this->hasMany(Medical_note::class, 'doctor_id');
    }


    public function answeredInquiries()
    {
        return $this->hasMany(Inquiry::class, 'response_by');
    }

    public function paymentsMade()
    {
        return $this->hasMany(Payment::class, 'paid_by');
    }

    public function elderlies(): HasMany
    {
        return $this->hasMany(ElderlyPerson::class, 'family_id');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role && ! $user->hasRole($user->role)) {
                $user->assignRole($user->role);
                if ($user->role === 'admin') {
                    $user->givePermissionTo(['create_room', 'edit_room', 'delete_room']);
                }
            }
        });
    }
}
