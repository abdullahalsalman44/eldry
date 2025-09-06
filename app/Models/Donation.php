<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_name',
        'donor_email',
        'donor_phone',
        'invoice_id',
        'amount',
        'payment_method',
    ];
}
