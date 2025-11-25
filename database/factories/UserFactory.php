<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string) Str::ulid(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'user',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function owner()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'owner',
                'is_active' => true,
            ];
        });
    }

    public function therapist()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'terapis',
                'is_active' => true,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'is_active' => true,
            ];
        });
    }

    public function assessor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'asesor',
                'is_active' => true,
            ];
        });
    }
}
