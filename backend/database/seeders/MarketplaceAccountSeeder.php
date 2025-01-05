<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MarketplaceType;
use App\Models\Marketplace;
use Illuminate\Database\Seeder;

class MarketplaceAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account = Marketplace::firstWhere('name', MarketplaceType::WILDBERRIES)->accounts()->create(['name' => 'Wildberries']);
        $account->settings()->create(['key' => 'token', 'value' => 'token']);

        $account = Marketplace::firstWhere('name', MarketplaceType::OZON)->accounts()->create(['name' => 'Ozon']);
        $account->settings()->create(['key' => 'Client-Id', 'value' => 'Client-Id']);
        $account->settings()->create(['key' => 'Api-Key', 'value' => 'Api-Key']);
    }
}