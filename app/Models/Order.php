<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'phone',
        'dni',
        'total_cents',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}