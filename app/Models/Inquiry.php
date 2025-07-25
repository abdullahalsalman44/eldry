<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{

    protected $fillable = [
        'user_id',
        'elderly_id',
        'message',
        'response',
        'status',
        'response_by',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
public function elderly()
{
    return $this->belongsTo(\App\Models\ElderlyPerson::class, 'elderly_id');
}
public function responder()
{
    return $this->belongsTo(User::class, 'response_by');
}
}
