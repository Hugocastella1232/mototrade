<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'listing_id',
        'status',
        'total_eur',
        'payment_provider',
        'payment_intent_id'
    ];

    protected $casts = [
        'status' => 'string'
    ];
}