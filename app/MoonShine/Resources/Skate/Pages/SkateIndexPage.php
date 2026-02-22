<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Skate\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use App\MoonShine\Resources\Skate\SkateResource;
use MoonShine\Support\ListOf;
use Throwable;

/**
 * @extends IndexPage<SkateResource>
 */
class SkateIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
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
     * @return ListOf<\MoonShine\UI\Components\ActionButton>
     */
    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            Text::make('Бренд', 'brand'),
            Number::make('Размер', 'size'),
            Switcher::make('Доступно', 'is_available'),
        ];
    }

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [
            QueryTag::make(
                'В наличии',
                fn($query) => $query->where('quantity', '>', 0)->where('is_available', true)
            ),
            QueryTag::make(
                'Нет в наличии',
                fn($query) => $query->where('quantity', '=', 0)->orWhere('is_available', false)
            ),
        ];
    }

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [
            ValueMetric::make('Всего коньков')
                ->value(fn() => $this->getResource()->getModel()::count()),
            ValueMetric::make('В наличии')
                ->value(fn() => $this->getResource()->getModel()::where('quantity', '>', 0)->count()),
        ];
    }

    /**
     * @param  TableBuilder  $component
     * @return TableBuilder
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component
            ->reindex()
            ->withAttributes(['class' => 'w-full']);
    }
}