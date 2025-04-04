<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

final class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::all()->each(function (Product $product): void {
            $users = User::inRandomOrder()->take(random_int(1, 5))->get();

            $users->each(function (User $user) use ($product): void {
                ProductReview::factory()->for($product)->for($user)->create();
            });
        });
    }
}
