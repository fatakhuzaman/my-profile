<?php

namespace Database\Factories;

use App\Enums\ResumeEntryType;
use App\Models\ResumeEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResumeEntry>
 */
class ResumeEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedOn = fake()->dateTimeBetween('-8 years', '-1 year');

        return [
            'type' => fake()->randomElement(ResumeEntryType::cases()),
            'title' => ['id' => fake()->jobTitle(), 'en' => fake()->jobTitle()],
            'organization' => fake()->company(),
            'description' => ['id' => fake()->sentence(), 'en' => fake()->sentence()],
            'started_on' => $startedOn,
            'ended_on' => fake()->dateTimeBetween($startedOn, 'now'),
            'date_precision' => 'year',
            'is_published' => true,
            'sort_order' => 0,
        ];
    }

    public function ofType(ResumeEntryType $type): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => $type,
        ]);
    }

    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'ended_on' => null,
        ]);
    }
}
