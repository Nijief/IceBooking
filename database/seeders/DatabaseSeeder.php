<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skate;
use App\Models\Booking;
use App\Models\Ticket;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $skates = [
            [
                'brand' => 'SD',
                'model' => 'VaX',
                'size' => 42,
                'quantity' => 5,
                'price_per_hour' => 150,
                'is_available' => true
            ],
            [
                'brand' => 'CiCM',
                'model' => 'Jred',
                'size' => 44,
                'quantity' => 3,
                'price_per_hour' => 150,
                'is_available' => true
            ],
            [
                'brand' => 'Grawf',
                'model' => 'Sara',
                'size' => 40,
                'quantity' => 4,
                'price_per_hour' => 170,
                'is_available' => true
            ],
            [
                'brand' => 'Bafer',
                'model' => 'DetS',
                'size' => 43,
                'quantity' => 2,
                'price_per_hour' => 160,
                'is_available' => true
            ],
            [
                'brand' => 'CiCM',
                'model' => 'Ribcor',
                'size' => 45,
                'quantity' => 3,
                'price_per_hour' => 150,
                'is_available' => true
            ],
            [
                'brand' => 'Graf',
                'model' => 'Cobra',
                'size' => 41,
                'quantity' => 4,
                'price_per_hour' => 140,
                'is_available' => true
            ],
        ];

        foreach ($skates as $skate) {
            Skate::create($skate);
        }
    }
}