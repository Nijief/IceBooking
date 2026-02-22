<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'full_name', 'phone', 'hours', 'skate_id',
        'with_skates', 'total_amount', 'payment_id',
        'payment_status', 'is_paid', 'paid_at'
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'with_skates' => 'boolean',
        'paid_at' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    public function skate(): BelongsTo
    {
        return $this->belongsTo(Skate::class);
    }

    public function markAsPaid(string $paymentId): void
    {
        $this->update([
            'is_paid' => true,
            'payment_status' => 'succeeded',
            'payment_id' => $paymentId,
            'paid_at' => now()
        ]);
    }
}