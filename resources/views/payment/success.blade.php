@extends('layouts.app')

@section('title', 'Оплата успешна')

@section('content')
    <div class="container py-10">
        <div class="success-container">
            <div class="success-icon"></div>
            
            <h1 class="success-title">Спасибо за оплату!</h1>
            
            <p class="success-message">
                Ваш платеж успешно обработан. Мы отправили подтверждение на ваш email и телефон.
            </p>

            <div class="card payment-card text-center">
                <h3 class="mb-3">Детали бронирования</h3>
                <p class="mb-2">Чек отправлен на email</p>
                <p class="mb-2">Подтверждение по SMS</p>
                <p>Ждем вас на катке!</p>
            </div>

            <div class="success-actions">
                <a href="/" class="btn btn-outline">На главную</a>
                <a href="/booking" class="btn btn-primary">Забронировать коньки</a>
            </div>
        </div>
    </div>
@endsection