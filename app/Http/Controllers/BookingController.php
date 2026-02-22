<?php

namespace App\Http\Controllers;

use App\Models\Skate;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function showForm()
    {
        $skates = Skate::where('is_available', true)
            ->where('quantity', '>', 0)
            ->get();
            
        return view('booking.form', compact('skates'));
    }

    public function process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'hours' => 'required|in:1,2,3,4',
            'with_skates' => 'boolean',
            'skate_id' => 'required_if:with_skates,1|exists:skates,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticketPrice = 300;
        $skatesPrice = 0;
        
        if ($request->with_skates) {
            $skate = Skate::find($request->skate_id);
            $skatesPrice = $skate->price_per_hour * $request->hours;
            
            $skate->decrement('quantity');
        }
        
        $totalAmount = $ticketPrice + $skatesPrice;

        $booking = Booking::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'hours' => $request->hours,
            'skate_id' => $request->with_skates ? $request->skate_id : null,
            'with_skates' => $request->with_skates ?? false,
            'total_amount' => $totalAmount,
        ]);

        $payment = $this->paymentService->createPayment($booking);

        return redirect($payment->getConfirmation()->getConfirmationUrl());
    }
}