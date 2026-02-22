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
            $paymentData = [
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
            ];

            $paymentData['receipt'] = [
                'customer' => [
                    'full_name' => $booking->full_name,
                    'phone' => $this->formatPhoneForReceipt($booking->phone),
                ],
                'items' => [
                    [
                        'description' => 'Входной билет на каток',
                        'quantity' => 1,
                        'amount' => [
                            'value' => number_format(300, 2, '.', ''),
                            'currency' => 'RUB',
                        ],
                        'vat_code' => 1,
                        'payment_mode' => 'full_prepayment',
                        'payment_subject' => 'service',
                    ]
                ]
            ];

            if ($booking->with_skates && $booking->skate) {
                $skatesAmount = $booking->total_amount - 300;
                $paymentData['receipt']['items'][] = [
                    'description' => 'Аренда коньков ' . $booking->skate->brand . ' ' . $booking->skate->model . ' (' . $booking->hours . ' ч)',
                    'quantity' => 1,
                    'amount' => [
                        'value' => number_format($skatesAmount, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'vat_code' => 1,
                    'payment_mode' => 'full_prepayment',
                    'payment_subject' => 'service',
                ];
            }

            Log::info('Creating payment with data', $paymentData);

            $payment = $this->client->createPayment(
                $paymentData,
                $idempotenceKey
            );

            $booking->payment_id = $payment->getId();
            $booking->save();

            return $payment;

        } catch (\Exception $e) {
            Log::error('Payment creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'booking_id' => $booking->id
            ]);
            throw $e;
        }
    }

    public function createTicketPayment(Ticket $ticket)
    {
        $idempotenceKey = uniqid('', true);

        try {
            $paymentData = [
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
                'receipt' => [
                    'customer' => [
                        'full_name' => $ticket->full_name,
                        'phone' => $this->formatPhoneForReceipt($ticket->phone),
                        'email' => $ticket->email ?? '',
                    ],
                    'items' => [
                        [
                            'description' => 'Входной билет на каток',
                            'quantity' => 1,
                            'amount' => [
                                'value' => number_format($ticket->amount, 2, '.', ''),
                                'currency' => 'RUB',
                            ],
                            'vat_code' => 1, // НДС 20%
                            'payment_mode' => 'full_prepayment',
                            'payment_subject' => 'service',
                        ]
                    ]
                ]
            ];

            Log::info('Creating ticket payment with data', $paymentData);

            $payment = $this->client->createPayment(
                $paymentData,
                $idempotenceKey
            );

            $ticket->payment_id = $payment->getId();
            $ticket->save();

            return $payment;

        } catch (\Exception $e) {
            Log::error('Ticket payment creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'ticket_id' => $ticket->id
            ]);
            throw $e;
        }
    }

    private function formatPhoneForReceipt($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (strlen($phone) == 10) {
            $phone = '7' . $phone;
        }
        if (strlen($phone) == 11 && $phone[0] == '8') {
            $phone[0] = '7';
        }
        
        return '+' . $phone;
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