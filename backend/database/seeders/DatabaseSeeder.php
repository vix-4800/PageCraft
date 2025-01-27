<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            RoleSeeder::class,
            UserSeeder::class,
            ProductAttributeSeeder::class,
            ProductSeeder::class,
            ProductReviewSeeder::class,
            SettingSeeder::class,
            TemplateSeeder::class,
            OrderSeeder::class,
            MarketplaceSeeder::class,
            MarketplaceAccountSeeder::class,
            FeedbackMessageSeeder::class,
            ArticleSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
    }
}
