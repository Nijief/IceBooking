<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skate extends Model
{
    protected $fillable = [
        'model', 'brand', 'size', 'quantity', 
        'price_per_hour', 'image', 'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price_per_hour' => 'decimal:2'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function isInStock(): bool
    {
        return $this->quantity > 0 && $this->is_available;
    }
}