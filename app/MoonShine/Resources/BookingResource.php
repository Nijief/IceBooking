<?php

namespace App\MoonShine\Resources;

use App\Models\Booking;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\DateTime;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\SwitchField;
use MoonShine\Fields\Decimal;

class BookingResource extends ModelResource
{
    protected string $model = Booking::class;

    protected string $title = 'Бронирования';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('ФИО', 'full_name'),
            Text::make('Телефон', 'phone'),
            Number::make('Часов', 'hours'),
            BelongsTo::make('Коньки', 'skate', 'model'),
            Decimal::make('Сумма', 'total_amount'),
            SwitchField::make('Оплачено', 'is_paid'),
            DateTime::make('Дата оплаты', 'paid_at'),
            DateTime::make('Создано', 'created_at'),
        ];
    }
}