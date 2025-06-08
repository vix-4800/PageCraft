<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariation>
 */
final class ProductVariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $allFiles = Storage::disk('public')->allFiles('products');
        $availableImages = array_filter(
            $allFiles,
            fn (string $file): bool|int => preg_match('/\.(jpe?g|png|webp|gif)$/i', $file)
        );

        return [
            'sku' => Str::sku(ProductVariation::class),
            'price' => $this->faker->numberBetween(50, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => $this->faker->randomElement($availableImages),
        ];
    }
}
