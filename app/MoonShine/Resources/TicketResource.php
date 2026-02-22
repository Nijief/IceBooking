<?php

namespace App\MoonShine\Resources;

use App\Models\Ticket;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\DateTime;
use MoonShine\Fields\SwitchField;
use MoonShine\Fields\Decimal;

class TicketResource extends ModelResource
{
    protected string $model = Ticket::class;

    protected string $title = 'Билеты';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('ФИО', 'full_name'),
            Text::make('Email', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Номер билета', 'ticket_number'),
            Decimal::make('Сумма', 'amount'),
            SwitchField::make('Оплачено', 'is_paid'),
            DateTime::make('Дата оплаты', 'paid_at'),
            DateTime::make('Использован', 'used_at'),
        ];
    }
}