<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём два магазина
        Store::create([
            'name' => 'Магазин №1',
            'address' => 'ул. Примерная, д. 1',
            'phone' => '+7 (999) 123-45-67',
            'is_active' => true,
        ]);

        Store::create([
            'name' => 'Магазин №2',
            'address' => 'ул. Образцовая, д. 2',
            'phone' => '+7 (999) 123-45-68',
            'is_active' => true,
        ]);
    }
}

