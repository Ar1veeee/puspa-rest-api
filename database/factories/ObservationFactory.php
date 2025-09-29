<?php

namespace Database\Factories;

use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Observation>
 */
class ObservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'child_id' => Child::factory(),
            'therapist_id' => null,
            'scheduled_date' => fake()->dateTimeBetween('+1 day', '+1 month'),
            'age_category' => fake()->randomElement(['balita', 'anak-anak', 'remaja', 'lainya']),
            'total_score' => null,
            'conclusion' => null,
            'recommendation' => null,
            'status' => 'Pending',
        ];
    }
}
