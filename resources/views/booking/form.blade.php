@extends('layouts.app')

@section('title', 'Бронирование коньков')

@section('content')
    <div class="container py-6">
        <div class="booking-container">
            <h1 class="booking-title">Бронирование коньков</h1>
            
            <div class="card">
                <form method="POST" action="{{ route('booking.process') }}" id="bookingForm">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="full_name">ФИО *</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                               id="full_name" name="full_name" value="{{ old('full_name') }}" required>
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
                        <label class="form-label" for="hours">Количество часов *</label>
                        <select class="form-control @error('hours') is-invalid @enderror" 
                                id="hours" name="hours" required>
                            <option value="">Выберите количество часов</option>
                            <option value="1" {{ old('hours') == 1 ? 'selected' : '' }}>1 час</option>
                            <option value="2" {{ old('hours') == 2 ? 'selected' : '' }}>2 часа</option>
                            <option value="3" {{ old('hours') == 3 ? 'selected' : '' }}>3 часа</option>
                            <option value="4" {{ old('hours') == 4 ? 'selected' : '' }}>4 часа</option>
                        </select>
                        @error('hours')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="with_skates" value="1" 
                                   {{ old('with_skates') ? 'checked' : '' }}
                                   onchange="toggleSkatesSelection(this.checked)">
                            <span>Нужны коньки</span>
                        </label>
                    </div>

                    <div id="skatesSelection" class="skates-selection" style="display: {{ old('with_skates') ? 'block' : 'none' }};">
                        <div class="form-group">
                            <label class="form-label" for="skate_id">Выберите коньки</label>
                            <select class="form-control @error('skate_id') is-invalid @enderror" 
                                    id="skate_id" name="skate_id">
                                <option value="">Выберите модель</option>
                                @foreach($skates as $skate)
                                    <option value="{{ $skate->id }}" 
                                            data-price="{{ $skate->price_per_hour }}"
                                            {{ old('skate_id') == $skate->id ? 'selected' : '' }}>
                                        {{ $skate->brand }} {{ $skate->model }} (Размер: {{ $skate->size }}) - {{ $skate->price_per_hour }} ₽/час
                                    </option>
                                @endforeach
                            </select>
                            @error('skate_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="price-summary">
                        <h3 class="mb-3">Итого к оплате:</h3>
                        <div class="price-row">
                            <span>Входной билет:</span>
                            <span>300 ₽</span>
                        </div>
                        <div class="price-row" id="skatesPriceRow" style="display: none;">
                            <span>Аренда коньков:</span>
                            <span id="skatesPrice">0 ₽</span>
                        </div>
                        <div class="price-total">
                            <span>Всего:</span>
                            <span id="totalPrice">300 ₽</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Перейти к оплате
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('phone').addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = !x[2] ? x[1] : '+7 (' + x[2] + (x[3] ? ') ' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
        });

        function toggleSkatesSelection(show) {
            document.getElementById('skatesSelection').style.display = show ? 'block' : 'none';
            updatePrice();
        }

        function updatePrice() {
            const hours = parseInt(document.getElementById('hours').value) || 0;
            const withSkates = document.querySelector('input[name="with_skates"]').checked;
            const skateSelect = document.getElementById('skate_id');
            const selectedSkate = skateSelect.options[skateSelect.selectedIndex];
            
            let basePrice = 300;
            let skatesPrice = 0;

            if (withSkates && selectedSkate && selectedSkate.value) {
                const pricePerHour = parseFloat(selectedSkate.dataset.price) || 150;
                skatesPrice = pricePerHour * hours;
                document.getElementById('skatesPriceRow').style.display = 'flex';
                document.getElementById('skatesPrice').textContent = skatesPrice + ' ₽';
            } else {
                document.getElementById('skatesPriceRow').style.display = 'none';
            }

            document.getElementById('totalPrice').textContent = (basePrice + skatesPrice) + ' ₽';
        }

        document.getElementById('hours').addEventListener('change', updatePrice);
        document.getElementById('skate_id').addEventListener('change', updatePrice);
    </script>
@endsection