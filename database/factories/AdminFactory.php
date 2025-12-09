<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string)Str::ulid(),
            'user_id' => User::factory()->admin()->create()->id,
            'admin_name' => fake()->name(),
            'admin_phone' => fake()->phoneNumber(),
            'admin_birth_date' => fake()->numberBetween(22, 40),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
