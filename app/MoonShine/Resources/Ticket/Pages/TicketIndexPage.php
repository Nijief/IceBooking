<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Ticket\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Resources\Ticket\TicketResource;

/**
 * @extends IndexPage<TicketResource>
 */
class TicketIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * Поля для отображения в таблице
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            
            Text::make('Номер билета', 'ticket_number')
                ->sortable(),
            
            Text::make('ФИО', 'full_name')
                ->sortable(),
            
            Email::make('Email', 'email'),
            
            Text::make('Телефон', 'phone'),
            
            Number::make('Сумма', 'amount')
                ->sortable()
                ->prefix('₽'),
            
            Switcher::make('Оплачено', 'is_paid')
                ->sortable(),
            
            Date::make('Дата оплаты', 'paid_at')
                ->sortable()
                ->format('d.m.Y H:i'),
            
            Date::make('Использован', 'used_at')
                ->sortable()
                ->format('d.m.Y H:i'),
            
            Text::make('ID платежа', 'payment_id'),
            
            Date::make('Создано', 'created_at')
                ->sortable()
                ->format('d.m.Y H:i'),
        ];
    }

    /**
     * Фильтры
     */
    protected function filters(): iterable
    {
        return [
            Text::make('Номер билета', 'ticket_number')
                ->placeholder('Поиск по номеру'),
            
            Text::make('ФИО', 'full_name')
                ->placeholder('Поиск по ФИО'),
            
            Switcher::make('Оплачено', 'is_paid'),
        ];
    }

    /**
     * Теги для быстрой фильтрации
     */
    protected function queryTags(): array
    {
        return [
            QueryTag::make('Все билеты', fn($query) => $query),
            QueryTag::make('Оплаченные', fn($query) => $query->where('is_paid', true)),
            QueryTag::make('Неоплаченные', fn($query) => $query->where('is_paid', false)),
            QueryTag::make('Использованные', fn($query) => $query->whereNotNull('used_at')),
            QueryTag::make('Неиспользованные', fn($query) => $query->whereNull('used_at')),
        ];
    }

    /**
     * Простые метрики
     */
    protected function metrics(): array
    {
        $model = $this->getResource()->getModel();
        
        return [
            ValueMetric::make('Всего билетов', $model::count()),
            ValueMetric::make('Оплачено', $model::where('is_paid', true)->count()),
            ValueMetric::make('Не оплачено', $model::where('is_paid', false)->count()),
        ];
    }
}