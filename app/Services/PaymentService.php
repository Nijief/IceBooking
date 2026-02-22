<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Ticket;
use YooKassa\Client;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $client;
    protected $shopId;
    protected $secretKey;

    public function __construct()
    {
        $this->shopId = config('services.yookassa.shop_id');
        $this->secretKey = config('services.yookassa.secret_key');
        
        $this->client = new Client();
        $this->client->setAuth($this->shopId, $this->secretKey);
        
        $this->client->setLogger(Log::channel('stack'));
    }

    public function createPayment(Booking $booking)
    {
        $idempotenceKey = uniqid('', true);

        try {
            $payment = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => number_format($booking->total_amount, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => route('payment.success'),
                    ],
                    'capture' => true,
                    'description' => 'Оплата бронирования катка #' . $booking->id,
                    'metadata' => [
                        'booking_id' => $booking->id,
                        'type' => 'booking'
                    ],
                    'test' => true,
                ],
                $idempotenceKey
            );

            $booking->payment_id = $payment->getId();
            $booking->save();

            return $payment;

        } catch (\Exception $e) {
            Log::error('Payment creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createTicketPayment(Ticket $ticket)
    {
        $idempotenceKey = uniqid('', true);

        try {
            $payment = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => number_format($ticket->amount, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => route('payment.success'),
                    ],
                    'capture' => true,
                    'description' => 'Оплата входного билета #' . $ticket->ticket_number,
                    'metadata' => [
                        'ticket_id' => $ticket->id,
                        'ticket_number' => $ticket->ticket_number,
                        'type' => 'ticket'
                    ],
                    'test' => true,
                ],
                $idempotenceKey
            );

            $ticket->payment_id = $payment->getId();
            $ticket->save();

            return $payment;

        } catch (\Exception $e) {
            Log::error('Ticket payment creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getPaymentInfo($paymentId)
    {
        try {
            return $this->client->getPaymentInfo($paymentId);
        } catch (\Exception $e) {
            Log::error('Get payment info failed: ' . $e->getMessage());
            return null;
        }
    }

    public function checkPaymentStatus($paymentId)
    {
        try {
            $payment = $this->getPaymentInfo($paymentId);
            return $payment ? $payment->getStatus() : null;
        } catch (\Exception $e) {
            Log::error('Check payment status failed: ' . $e->getMessage());
            return null;
        }
    }
}