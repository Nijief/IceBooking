<?php

namespace App\Services;

use App\Models\Booking;
use YooKassa\Client;

class PaymentService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );
    }

    public function createPayment(Booking $booking)
    {
        $idempotenceKey = uniqid('', true);

        $payment = $this->client->createPayment(
            [
                'amount' => [
                    'value' => $booking->total_amount,
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => route('payment.success'),
                ],
                'capture' => true,
                'description' => 'Оплата бронирования катка',
                'metadata' => [
                    'booking_id' => $booking->id,
                ],
            ],
            $idempotenceKey
        );

        return $payment;
    }
}