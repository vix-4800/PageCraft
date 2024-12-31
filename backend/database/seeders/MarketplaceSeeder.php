<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MarketplaceType;
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
            'name' => MarketplaceType::WILDBERRIES,
            'base_url' => 'https://www.wildberries.ru',
        ]);

        Marketplace::create([
            'name' => MarketplaceType::OZON,
            'base_url' => 'https://www.ozon.ru',
        ]);

        Marketplace::create([
            'name' => MarketplaceType::YANDEX,
            'base_url' => 'https://market.yandex.ru',
        ]);
    }
}
