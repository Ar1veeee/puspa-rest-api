<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Therapist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ObservationFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'scheduled', 'completed']);
        $createdAt = fake()->dateTimeBetween('-6 months', 'now');

        return [
            'child_id' => Child::factory(),
            'therapist_id' => Therapist::factory(),
            'scheduled_date' => $status !== 'pending' ? fake()->dateTimeBetween($createdAt, '+1 week') : null,
            'age_category' => fake()->randomElement(['balita', 'anak-anak', 'remaja']),
            'total_score' => $status === 'completed' ? fake()->numberBetween(50, 100) : null,
            'conclusion' => $status === 'completed' ? fake()->paragraph() : null,
            'recommendation' => $status === 'completed' ? fake()->paragraph() : null,
            'status' => $status,
            'completed_at' => $status === 'completed' ? fake()->time() : '00:00:00',
            'is_continued_to_assessment' => $status === 'completed' ? fake()->boolean(60) : false,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'total_score' => fake()->numberBetween(50, 100),
            'conclusion' => fake()->paragraph(),
            'recommendation' => fake()->paragraph(),
            'completed_at' => fake()->time(),
            'is_continued_to_assessment' => fake()->boolean(70),
        ]);
    }

    public function inMonth(int $month, int $year): static
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        return $this->state(fn (array $attributes) => [
            'created_at' => fake()->dateTimeBetween($startDate, $endDate),
        ]);
    }
}
