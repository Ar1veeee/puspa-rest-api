<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TherapistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string)Str::ulid(),
            'user_id' => User::factory()->therapist()->create()->id,
            'therapist_name' => fake()->name(),
            'therapist_section' => fake()->randomElement(['okupasi', 'fisio', 'wicara', 'paedagog']),
            'therapist_phone' => fake()->phoneNumber(),
            'therapist_birth_date' => fake()->numberBetween(22, 40),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function section(string $section): static
    {
        return $this->state(fn(array $attributes) => [
            'therapist_section' => $section,
        ]);
    }
}
