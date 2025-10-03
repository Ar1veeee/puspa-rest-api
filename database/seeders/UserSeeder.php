<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('Admin123.'),
                'email_verified_at' => Carbon::now(),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'username' => 'ownerPuspa',
                'email' => 'ownerpuspa@example.com',
                'password' => Hash::make('Owner123.'),
                'email_verified_at' => Carbon::now(),
                'role' => 'owner',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user); // otomatis generate ULID untuk kolom id
        }
    }
}
