<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ObservationQuestion>
 */
class ObservationQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_code' => strtoupper(fake()->unique()->bothify('???-##')),
            'age_category' => fake()->randomElement(['balita', 'anak-anak', 'remaja', 'lainya']),
            'question_number' => fake()->unique()->numberBetween(1, 100),
            'question_text' => fake()->sentence() . '?',
            'score' => fake()->numberBetween(1, 3),
            'is_active' => true,
        ];
    }
}
