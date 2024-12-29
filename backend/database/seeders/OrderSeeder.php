<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ProductVariation;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::inRandomOrder()->take(random_int(1, 5))->each(function (User $user): void {
            $items = ProductVariation::inRandomOrder()->take(random_int(1, 5))->get();
            Order::factory(random_int(1, 5))->for($user)->create();
        });
    }
}
