<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\FeedbackSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackMessage>
 */
class FeedbackMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->safeEmail,
            'phone' => fake()->phoneNumber,
            'message' => fake()->text,
            'subject' => fake()->randomElement(FeedbackSubject::values()),
        ];
    }
}
