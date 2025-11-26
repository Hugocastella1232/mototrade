<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'listing_id',
        'user_id',
        'name',
        'email',
        'message'
    ];

    const UPDATED_AT = null;
}