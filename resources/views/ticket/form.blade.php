@extends('layouts.app')

@section('title', 'Покупка билета')

@section('content')
    <div class="container py-6">
        <div class="ticket-container">
            <h1 class="booking-title">Покупка входного билета</h1>
            
            <div class="card text-center">
                <div class="ticket-header">
                    <div class="ticket-icon">🎫</div>
                    <h2 class="ticket-price">300 ₽</h2>
                    <p class="ticket-description">Один билет действует весь день</p>
                </div>

                <form method="POST" action="{{ route('ticket.process') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="full_name">ФИО *</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                               id="full_name" name="full_name" value="{{ old('full_name') }}" 
                               placeholder="Иванов Иван Иванович" required>
                        @error('full_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Телефон *</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" 
                               placeholder="+7 (___) ___-__-__" required>
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email (необязательно)</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="ivan@example.com">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(session('error'))
                        <div class="alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="ticket-summary">
                        <div class="ticket-total">
                            <span class="ticket-total-label">К оплате:</span>
                            <span class="ticket-total-price">300 ₽</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Оплатить билет
                    </button>
                </form>
            </div>

            <div class="ticket-info">
                <p class="ticket-info-text">
                    После оплаты вы получите билет с уникальным номером.<br>
                    Его нужно будет показать на входе.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('phone').addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = !x[2] ? x[1] : '+7 (' + x[2] + (x[3] ? ') ' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
        });
    </script>
@endsection