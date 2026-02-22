<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function success(Request $request)
    {
        return view('payment.success');
    }

    public function webhook(Request $request)
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        Log::info('Payment webhook received', ['data' => $requestBody]);

        try {
            if ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED) {
                $notification = new NotificationSucceeded($requestBody);
                $payment = $notification->getObject();
                
                $metadata = $payment->getMetadata();
                
                if ($metadata && isset($metadata['booking_id'])) {
                    $this->processBookingPayment($payment);
                } elseif ($metadata && isset($metadata['ticket_id'])) {
                    $this->processTicketPayment($payment);
                }
                
                Log::info('Payment processed successfully', [
                    'payment_id' => $payment->getId(),
                    'status' => $payment->getStatus()
                ]);
            }

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            Log::error('Payment webhook error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function processBookingPayment($payment)
    {
        $metadata = $payment->getMetadata();
        $booking = Booking::find($metadata['booking_id']);
        
        if ($booking && !$booking->is_paid) {
            $booking->markAsPaid($payment->getId());
            
            Log::info('Booking payment processed', [
                'booking_id' => $booking->id,
                'payment_id' => $payment->getId()
            ]);
        }
    }

    protected function processTicketPayment($payment)
    {
        $metadata = $payment->getMetadata();
        $ticket = Ticket::find($metadata['ticket_id']);
        
        if ($ticket && !$ticket->is_paid) {
            $ticket->markAsPaid($payment->getId());
            
            Log::info('Ticket payment processed', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'payment_id' => $payment->getId()
            ]);
        }
    }

    public function testConnection()
    {
        try {
            $paymentInfo = $this->paymentService->getPaymentInfo('test_payment');
            
            return response()->json([
                'status' => 'connected',
                'message' => 'Подключение к ЮKassa успешно'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка подключения: ' . $e->getMessage()
            ], 500);
        }
    }
}