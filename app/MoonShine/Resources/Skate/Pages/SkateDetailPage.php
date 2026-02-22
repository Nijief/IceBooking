<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Skate\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;

class SkateDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Бренд', 'brand'),
            Text::make('Модель', 'model'),
            Number::make('Размер', 'size'),
            Number::make('Количество', 'quantity'),
            Number::make('Цена за час', 'price_per_hour'),
            Image::make('Изображение', 'image')->disk('public'),
            Switcher::make('Доступно', 'is_available'),
        ];
    }
}