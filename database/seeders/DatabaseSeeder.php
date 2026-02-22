<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skate;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $skates = [
            ['brand' => 'Bauer', 'model' => 'RT', 'size' => 42, 'quantity' => 5],
            ['brand' => 'CCM', 'model' => 'GFFF', 'size' => 44, 'quantity' => 3],
            ['brand' => 'Graf', 'model' => 'Gift', 'size' => 40, 'quantity' => 4],
            ['brand' => 'Bauer', 'model' => 'Boost', 'size' => 43, 'quantity' => 2],
            ['brand' => 'CCM', 'model' => 'Light', 'size' => 45, 'quantity' => 3],
            ['brand' => 'Graf', 'model' => 'Cobra', 'size' => 41, 'quantity' => 4],
        ];

        foreach ($skates as $skate) {
            Skate::create(array_merge($skate, [
                'price_per_hour' => 150,
                'is_available' => true
            ]));
        }
    }
}