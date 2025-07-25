<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    public function elderly()
{
    return $this->belongsTo(ElderlyPerson::class, 'elderly_id');
}

    protected $fillable=['title','date','description','image_url','target_type','elderly_id'];
}
