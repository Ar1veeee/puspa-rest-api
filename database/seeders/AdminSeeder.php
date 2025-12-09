<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            ['name' => 'Annisa Koirul', 'username' => 'adminAnnisa', 'email' => 'annisa@admin.com', 'password' => Hash::make('Annisa123.'), 'phone' => '089522001987'],
        ];

        foreach ($admins as $admin) {
            $user = User::create([
                'username' => $admin['username'],
                'email' => $admin['email'],
                'password' => $admin['password'],
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
            ]);

            Admin::create([
                'user_id' => $user->id,
                'admin_name' => $admin['name'],
                'admin_phone' => $admin['phone'],
                'admin_birth_date' => Carbon::now()->subYears(30),
            ]);
        }
    }
}
