<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthDate = fake()->dateTimeBetween('-15 years', '-3 years');
        return [
            'family_id' => Family::factory(),
            'child_name' => fake()->name(),
            'child_gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'child_birth_place' => fake()->city(),
            'child_birth_date' => $birthDate,
            'child_address' => fake()->address(),
            'child_complaint' => fake()->sentence(),
            'child_school' => 'Sekolah ' . fake()->company(),
            'child_service_choice' => fake()->word(),
        ];
    }
}
