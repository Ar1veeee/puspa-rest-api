<?php

namespace Database\Factories;

use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ChildFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string)Str::ulid(),
            'family_id' => Family::factory()->create()->id,
            'child_name' => fake()->firstName(),
            'child_birth_place' => fake()->city(),
            'child_birth_date' => fake()->dateTimeBetween('-15 years', '-1 year'),
            'child_address' => fake()->address(),
            'child_complaint' => fake()->sentence(),
            'child_school' => fake()->optional()->company() . ' School',
            'child_service_choice' => fake()->randomElement(['Terapi Wicara', 'Fisioterapi', 'Okupasi', 'Paedagog']),
            'child_religion' => fake()->randomElement(['islam', 'kristen', 'katolik', 'hindu', 'budha']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
