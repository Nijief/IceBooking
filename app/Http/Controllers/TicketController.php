<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function showForm()
    {
        return view('ticket.form');
    }

    public function process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket = Ticket::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'amount' => 300,
        ]);

        try {
            $payment = $this->paymentService->createTicketPayment($ticket);

            return redirect($payment->getConfirmation()->getConfirmationUrl());

        } catch (\Exception $e) {
            $ticket->delete();
            
            return redirect()->back()
                ->with('error', 'Произошла ошибка при создании платежа. Пожалуйста, попробуйте позже.')
                ->withInput();
        }
    }
}