<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
final class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        $allFiles = Storage::disk('public')->allFiles('products');
        $availableImages = array_filter(
            $allFiles,
            fn (string $file): bool|int => preg_match('/\.(jpe?g|png|webp|gif)$/i', $file)
        );

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text,
            'product_images' => $this->faker->randomElements($availableImages, 3),
        ];
    }
}
