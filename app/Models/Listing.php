<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_SOLD_PENDING = 'sold_pending';
    const STATUS_SOLD = 'sold';

    protected $casts = [
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
        'listing_condition',
        'price_eur',
        'status',
        'location',
        'description',
        'image',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}