<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FamilyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string) Str::ulid(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
