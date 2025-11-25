<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Admin;
use App\Models\Therapist;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssessmentDetailFactory extends Factory
{
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'scheduled', 'completed']);

        return [
            'assessment_id' => Assessment::factory(),
            'type' => fake()->randomElement(['fisio', 'okupasi', 'wicara', 'paedagog']),
            'admin_id' => Admin::factory(),
            'therapist_id' => Therapist::factory(),
            'status' => $status,
            'scheduled_date' => $status !== 'pending' ? fake()->dateTimeBetween('now', '+2 weeks') : null,
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'parent_completed_status' => $status === 'completed' ? fake()->boolean(80) : false,
            'parent_completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}
