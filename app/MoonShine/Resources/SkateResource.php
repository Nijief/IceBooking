<?php

namespace App\MoonShine\Resources;

use App\Models\Skate;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\Image;
use MoonShine\Fields\SwitchField;
use MoonShine\Fields\Decimal;

class SkateResource extends ModelResource
{
    protected string $model = Skate::class;

    protected string $title = 'Коньки';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Бренд', 'brand')->required(),
            Text::make('Модель', 'model')->required(),
            Number::make('Размер', 'size')->required(),
            Number::make('Количество', 'quantity')->required(),
            Decimal::make('Цена за час', 'price_per_hour')->required(),
            Image::make('Изображение', 'image'),
            SwitchField::make('Доступно', 'is_available'),
        ];
    }

    public function rules($item): array
    {
        return [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'size' => 'required|integer|min:30|max:47',
            'quantity' => 'required|integer|min:0',
            'price_per_hour' => 'required|numeric|min:0',
        ];
    }
}