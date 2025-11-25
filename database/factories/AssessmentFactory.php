<?php

namespace Database\Factories;

use App\Models\Observation;
use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssessmentFactory extends Factory
{
    public function definition(): array
    {
        $observation = Observation::factory()->completed()->create();

        return [
            'observation_id' => $observation->id,
            'child_id' => $observation->child_id,
            'created_at' => $observation->created_at,
            'updated_at' => $observation->updated_at,
        ];
    }
}
