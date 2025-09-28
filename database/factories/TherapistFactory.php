<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Therapist>
 */
class TherapistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'terapis']),
            'therapist_name' => fake()->name(),
            'therapist_section' => fake()->randomElement(['Okupasi', 'Fisio', 'Wicara', 'Paedagog']),
            'therapist_phone' => fake()->phoneNumber(),
        ];
    }
}
