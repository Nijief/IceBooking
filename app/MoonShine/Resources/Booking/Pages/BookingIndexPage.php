<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Booking\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Switcher;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\Decimal;

class BookingIndexPage extends IndexPage
{
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('ФИО', 'full_name')->sortable(),
            Text::make('Телефон', 'phone'),
            Number::make('Часов', 'hours')->sortable(),
            BelongsTo::make('Коньки', 'skate', 'model'),
            Number::make('Сумма', 'total_amount')->sortable(),
            Switcher::make('Оплачено', 'is_paid')->sortable(),
            Date::make('Создано', 'created_at')->sortable(),
        ];
    }

    protected function filters(): iterable
    {
        return [
            Text::make('ФИО', 'full_name'),
            Switcher::make('Оплачено', 'is_paid'),
        ];
    }
}