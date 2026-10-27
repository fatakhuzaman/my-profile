<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
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
            'body' => ['id' => fake()->paragraphs(3, true), 'en' => fake()->paragraphs(3, true)],
            'client_name' => fake()->company(),
            'year' => (int) fake()->year(),
            'project_url' => fake()->url(),
            'is_featured' => false,
            'sort_order' => 0,
            'published_at' => fake()->dateTimeBetween('-2 years', '-1 day'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
