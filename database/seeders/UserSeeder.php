<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // cari dulu kalau sudah ada
            [
                'username' => 'admin',
                'password' => Hash::make('Admin123.'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
