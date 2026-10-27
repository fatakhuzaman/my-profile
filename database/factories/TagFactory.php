<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameId = fake()->unique()->word();
        $nameEn = fake()->unique()->word();

        return [
            'name' => ['id' => $nameId, 'en' => $nameEn],
            'slug' => ['id' => Str::slug($nameId), 'en' => Str::slug($nameEn)],
        ];
    }
}
