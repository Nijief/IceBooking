<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Booking;

use App\Models\Booking;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\PageContract;
use App\MoonShine\Resources\Booking\Pages\BookingIndexPage;
use App\MoonShine\Resources\Booking\Pages\BookingFormPage;
use App\MoonShine\Resources\Booking\Pages\BookingDetailPage;

class BookingResource extends ModelResource
{
    protected string $model = Booking::class;

    protected string $title = 'Бронирования';
    
    protected string $column = 'full_name';

    protected array $with = ['skate'];

    /**
     * @return list<PageContract>
     */
    protected function pages(): array
    {
        return [
            BookingIndexPage::class,
            BookingFormPage::class,
            BookingDetailPage::class,
        ];
    }

    /**
     * @param Booking $item
     * @return array<string, string[]>
     */
    protected function rules(mixed $item): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'hours' => ['required', 'integer', 'in:1,2,3,4'],
            'with_skates' => ['boolean'],
            'skate_id' => ['nullable', 'exists:skates,id'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'payment_id' => ['nullable', 'string', 'max:255'],
            'is_paid' => ['boolean'],
            'paid_at' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function search(): array
    {
        return [
            'id',
            'full_name',
            'phone',
            'payment_id',
        ];
    }
}