<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ReviewReactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReviewReaction>
 */
class ProductReviewReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(ReviewReactionType::values()),
        ];
    }
}
