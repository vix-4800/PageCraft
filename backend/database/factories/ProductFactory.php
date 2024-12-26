<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => fn (array $attributes): string => Str::slug($attributes['name']),
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl(category: 'products'),
            'additional_images' => [
                $this->faker->imageUrl(category: 'products'),
                $this->faker->imageUrl(category: 'products'),
                $this->faker->imageUrl(category: 'products'),
            ],
        ];
    }
}
