<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
final class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'text' => $this->faker->text,
            'status' => $this->faker->randomElement(ReviewStatus::cases()),
        ];
    }
}
