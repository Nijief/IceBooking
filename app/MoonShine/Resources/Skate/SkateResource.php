<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Skate;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Div;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Laravel\Pages\CrudPage;
use MoonShine\Laravel\Pages\ModelPage;

class SkateResource extends ModelResource
{
    protected string $model = Skate::class;

    protected string $title = 'Коньки';
    
    protected string $column = 'model';

    protected array $with = ['bookings'];

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Бренд', 'brand')->sortable(),
            Text::make('Модель', 'model')->sortable(),
            Number::make('Размер', 'size')->sortable(),
            Number::make('Количество', 'quantity')->sortable(),
            Number::make('Цена за час', 'price_per_hour')->sortable(),
            Image::make('Изображение', 'image')->disk('public'),
            Switcher::make('Доступно', 'is_available')->sortable(),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function formFields(): array
    {
        return [
            ID::make()->sortable(),
            
            Grid::make([
                Column::make([
                    Text::make('Бренд', 'brand')
                        ->required()
                        ->placeholder('Введите бренд'),
                    
                    Text::make('Модель', 'model')
                        ->required()
                        ->placeholder('Введите модель'),
                    
                    Number::make('Размер', 'size')
                        ->required()
                        ->min(30)
                        ->max(47)
                        ->step(1)
                        ->placeholder('Выберите размер'),
                ])->columnSpan(6),
                
                Column::make([
                    Number::make('Количество', 'quantity')
                        ->required()
                        ->min(0)
                        ->step(1)
                        ->placeholder('Введите количество'),
                    
                    Number::make('Цена за час', 'price_per_hour')
                        ->required()
                        ->min(0)
                        ->step(0.01)
                        ->placeholder('150'),
                    
                    Image::make('Изображение', 'image')
                        ->disk('public')
                        ->dir('skates')
                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'webp']),
                    
                    Switcher::make('Доступно', 'is_available')
                        ->default(true),
                ])->columnSpan(6),
            ]),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): array
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

    /**
     * @return array
     */
    protected function search(): array
    {
        return ['id', 'brand', 'model', 'size'];
    }

    /**
     * @return array
     */
    protected function filters(): array
    {
        return [
            Text::make('Бренд', 'brand'),
            Number::make('Размер', 'size'),
            Switcher::make('Доступно', 'is_available'),
        ];
    }

    /**
     * @param Skate $item
     * @return array<string, string[]>
     */
    protected function rules(mixed $item): array
    {
        return [
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'size' => ['required', 'integer', 'min:30', 'max:47'],
            'quantity' => ['required', 'integer', 'min:0'],
            'price_per_hour' => ['required', 'numeric', 'min:0', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_available' => ['boolean'],
        ];
    }

    /**
     * @return list<class-string<Page>>
     */
    protected function pages(): array
    {
        return [
        ];
    }
}