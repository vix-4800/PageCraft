<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'content' => $this->faker->text,
            'description' => $this->faker->text,
            'author' => $this->faker->name,
            'image' => $this->faker->imageUrl(category: 'articles'),
        ];
    }

    /**
     * Set the article status.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ArticleStatus::PUBLISHED,
        ]);
    }

    /**
     * Set the article status.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ArticleStatus::ARCHIVED,
        ]);
    }
}
