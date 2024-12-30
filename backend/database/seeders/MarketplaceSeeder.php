<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Marketplace;
use Illuminate\Database\Seeder;

class MarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Marketplace::create([
            'name' => 'Wildberries',
            'base_url' => 'https://www.wildberries.ru',
        ]);

        Marketplace::create([
            'name' => 'Ozon',
            'base_url' => 'https://www.ozon.ru',
        ]);
    }
}
