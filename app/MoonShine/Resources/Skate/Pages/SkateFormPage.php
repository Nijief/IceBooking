<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Skate\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Components\Layout\Flex;
use App\MoonShine\Resources\Skate\SkateResource;
use Throwable;

/**
 * @extends FormPage<SkateResource>
 */
class SkateFormPage extends FormPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            
            Flex::make([
                Text::make('Бренд', 'brand')
                    ->required()
                    ->placeholder('Введите бренд'),
                
                Text::make('Модель', 'model')
                    ->required()
                    ->placeholder('Введите модель'),
            ]),
            
            Flex::make([
                Number::make('Размер', 'size')
                    ->required()
                    ->min(30)
                    ->max(47)
                    ->step(1)
                    ->buttons()
                    ->placeholder('Размер'),
                
                Number::make('Количество', 'quantity')
                    ->required()
                    ->min(0)
                    ->step(1)
                    ->buttons()
                    ->placeholder('Количество'),
            ]),
            
            Flex::make([
                Number::make('Цена за час', 'price_per_hour')
                    ->required()
                    ->min(0)
                    ->step(0.01)
                    ->placeholder('150 ₽'),
                
                Image::make('Изображение', 'image')
                    ->disk('public')
                    ->dir('skates')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'webp']),
            ]),
            
            Switcher::make('Доступно', 'is_available')
                ->default(true),
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}