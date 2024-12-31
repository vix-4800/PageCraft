<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
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
            Order::factory(random_int(1, 5))->for($user)->create()->each(function (Order $order): void {
                $orderItems = OrderItem::create([
                    'order_id' => $order->id,
                    'product_variation_id' => ProductVariation::inRandomOrder()->first()->id,
                    'quantity' => random_int(1, 5),
                ]);

                $order->items()->save($orderItems);
            });
        });
    }
}
