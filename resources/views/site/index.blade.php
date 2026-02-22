@extends('layouts.app')

@section('title', 'Ледовый каток - Главная')

@section('content')
    <section class="hero">
        <div class="container">
            <h1 class="fade-in">Добро пожаловать на ледовую арену!</h1>
            <p class="fade-in" style="animation-delay: 0.2s;">Почувствуйте магию льда с комфортом и стилем</p>
            <div class="fade-in" style="animation-delay: 0.4s;">
                <a href="/booking" class="btn btn-accent mr-4">Забронировать коньки</a>
                <a href="/ticket" class="btn btn-outline" style="border-color: white; color: white;">Купить билет</a>
            </div>
        </div>
    </section>

    <div class="container">
        <section id="prices" class="section">
            <h2 class="section-title">Наши цены</h2>
            
            <div class="grid grid-2">
                <div class="card text-center">
                    <div class="card-icon">🎫</div>
                    <h3 class="card-title">Входной билет</h3>
                    <p class="card-price">300 ₽</p>
                    <p class="card-description">Один билет = весь день на катке</p>
                    <a href="/ticket" class="btn btn-primary">Купить билет</a>
                </div>

                <div class="card text-center">
                    <div class="card-icon">⛸️</div>
                    <h3 class="card-title">Аренда коньков</h3>
                    <p class="card-price">150 ₽/час</p>
                    <p class="card-description">Профессиональные коньки разных размеров</p>
                    <a href="/booking" class="btn btn-outline">Забронировать</a>
                </div>
            </div>
        </section>

        <section id="skates" class="section">
            <h2 class="section-title">Наши коньки</h2>
            
            <div class="grid grid-3">
                @foreach($skates as $skate)
                <div class="card">
                    <div class="card-image">⛸️</div>
                    <h3 class="mb-2">{{ $skate->brand }} {{ $skate->model }}</h3>
                    <p class="card-text">Размер: {{ $skate->size }}</p>
                    <p class="card-price">{{ $skate->price_per_hour }} ₽/час</p>
                    <p class="card-status {{ $skate->isInStock() ? 'status-in-stock' : 'status-out-of-stock' }}">
                        {{ $skate->isInStock() ? 'В наличии: ' . $skate->quantity : 'Нет в наличии' }}
                    </p>
                </div>
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="grid grid-3">
                <div class="feature">
                    <div class="feature-icon">❄️</div>
                    <h4 class="feature-title">Идеальный лед</h4>
                    <p class="feature-description">Профессиональная заливка льда каждые 2 часа</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">🏆</div>
                    <h4 class="feature-title">Профессиональный инвентарь</h4>
                    <p class="feature-description">Коньки лучших мировых брендов</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">☕</div>
                    <h4 class="feature-title">Уютное кафе</h4>
                    <p class="feature-description">Согревающие напитки и легкие закуски</p>
                </div>
            </div>
        </section>
    </div>
@endsection