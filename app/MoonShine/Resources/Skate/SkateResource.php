<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Skate;

use App\Models\Skate;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\Contracts\Core\PageContract;
use App\MoonShine\Resources\Skate\Pages\SkateIndexPage;
use App\MoonShine\Resources\Skate\Pages\SkateFormPage;
use App\MoonShine\Resources\Skate\Pages\SkateDetailPage;

class SkateResource extends ModelResource
{
    protected string $model = Skate::class;

    protected string $title = 'Коньки';
    
    protected string $column = 'model';

    protected array $with = ['bookings'];

    /**
     * @return list<PageContract>
     */
    protected function pages(): array
    {
        return [
            SkateIndexPage::class,
            SkateFormPage::class,
            SkateDetailPage::class,
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
     * @return array<string, string>
     */
    protected function search(): array
    {
        return [
            'id',
            'brand',
            'model',
            'size',
        ];
    }
}