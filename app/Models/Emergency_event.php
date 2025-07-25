<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emergency_event extends Model
{

    protected $fillable = [
        'elderly_id',
        'triggered_by',
        'type',
        'description',
        'notified_roles',
        'occurred_at',
    ];

    protected $casts = [
        'notified_roles' => 'array',
        'occurred_at' => 'datetime',
    ];
    public function elderly()
    {
        return $this->belongsTo(ElderlyPerson::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'triggered_by');
    }
}
