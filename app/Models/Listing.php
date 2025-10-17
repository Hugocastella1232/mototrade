<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    public const STATUS_PENDING  = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;

    protected $casts = [
        'status' => 'integer',
        'published_at' => 'datetime',
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
        'condition',
        'price_cents',
        'status',
        'location',
        'description',
        'image',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function photos()
    {
        return $this->hasMany(\App\Models\ListingPhoto::class);
    }
}