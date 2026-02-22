<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;

Route::get('/', [SiteController::class, 'index'])->name('home');

Route::get('/booking', [BookingController::class, 'showForm'])->name('booking.form');
Route::post('/booking', [BookingController::class, 'process'])->name('booking.process');

Route::get('/ticket', [TicketController::class, 'showForm'])->name('ticket.form');
Route::post('/ticket', [TicketController::class, 'process'])->name('ticket.process');

Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');