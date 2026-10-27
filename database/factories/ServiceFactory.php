<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titleId = rtrim(fake()->unique()->sentence(3), '.');
        $titleEn = rtrim(fake()->unique()->sentence(3), '.');

        return [
            'title' => ['id' => $titleId, 'en' => $titleEn],
            'slug' => ['id' => Str::slug($titleId), 'en' => Str::slug($titleEn)],
            'excerpt' => ['id' => fake()->sentence(), 'en' => fake()->sentence()],
            'body' => ['id' => fake()->paragraphs(2, true), 'en' => fake()->paragraphs(2, true)],
            'icon' => null,
            'is_featured' => false,
            'is_published' => true,
            'sort_order' => 0,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
