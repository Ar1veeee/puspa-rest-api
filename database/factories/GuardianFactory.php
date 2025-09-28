<?php

namespace Database\Factories;

use App\Models\Family;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guardian>
 */
class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'family_id' => Family::factory(),

            'user_id' => null,

            'temp_email' => fake()->unique()->safeEmail(),
            'guardian_type' => fake()->randomElement(['Ayah', 'Ibu', 'Wali']),
            'guardian_name' => fake()->name(),
            'guardian_phone' => fake()->phoneNumber(),
            'guardian_age' => fake()->numberBetween(25, 60),
            'guardian_occupation' => fake()->jobTitle(),
            'relationship_with_child' => null,
        ];
    }
}
