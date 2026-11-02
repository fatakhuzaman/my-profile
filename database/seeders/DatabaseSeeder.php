<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ContentSeeder::class);

        // The admin account is created with `php artisan make:filament-user`;
        // this throwaway login only exists on local machines.
        if (app()->isLocal()) {
            User::query()->firstOrCreate(
                ['email' => 'test@example.com'],
                User::factory()->raw(['name' => 'Test User', 'email' => 'test@example.com']),
            );
        }
    }
}
