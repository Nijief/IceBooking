<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'ticket_number',
        'amount', 'payment_id', 'payment_status', 
        'is_paid', 'paid_at', 'used_at'
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'used_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($ticket) {
            $ticket->ticket_number = 'TKT-' . strtoupper(uniqid());
        });
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