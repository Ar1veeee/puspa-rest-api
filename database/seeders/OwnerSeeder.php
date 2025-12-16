<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'ownerPuspa',
            'email' => 'owner@puspa.com',
            'password' => Hash::make('Owner123.'),
            'email_verified_at' => Carbon::now(),
            'is_active' => true,
        ]);

        $user->assignRole('owner');
    }
}
