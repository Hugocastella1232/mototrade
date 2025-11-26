<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    const STATUS_PENDING  = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const UPDATED_AT = null;

    protected $casts = [
        'status' => 'integer',
        'published_at' => 'datetime'
    ];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'brand',
        'model',
        'year',
        'km',
        'power_hp',
        'displacement_cc',
        'fuel',
        'listing_condition',
        'price_eur',
        'status',
        'location',
        'description',
        'image',
        'published_at'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}