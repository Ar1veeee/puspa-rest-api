<?php

namespace Database\Seeders;

use App\Models\Therapist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $therapists = [
            ['name' => 'Alief Arifun', 'username' => 'okupasiAlief', 'email' => 'alief@terapis.com', 'password' => Hash::make('Alief123.'), 'phone' => '089299886565', 'section' => 'okupasi', 'role' => 'asesor'],
            ['name' => 'Nindya Zahri', 'username' => 'fisioNindya', 'email' => 'nindya@terapis.com', 'password' => Hash::make('Nindya123.'), 'phone' => '089299886188', 'section' => 'fisio', 'role' => 'terapis'],
            ['name' => 'Alfian Plumek', 'username' => 'okupasiAlfian', 'email' => 'alfian@terapis.com', 'password' => Hash::make('Alfian123.'), 'phone' => '089299881199', 'section' => 'okupasi', 'role' => 'terapis'],
            ['name' => 'Rano Karno', 'username' => 'wicaraRano', 'email' => 'rano@terapis.com', 'password' => Hash::make('Rano123.'), 'phone' => '089299224288', 'section' => 'wicara', 'role' => 'terapis'],
            ['name' => 'Adit Tolongin', 'username' => 'paedagogAdit', 'email' => 'adit@terapis.com', 'password' => Hash::make('Adit123.'), 'phone' => '089211096188', 'section' => 'paedagog', 'role' => 'terapis'],
        ];

        foreach ($therapists as $therapist) {
            $user = User::create([
                'username' => $therapist['username'],
                'email' => $therapist['email'],
                'password' => $therapist['password'],
                'role' => $therapist['role'],
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
            ]);

            Therapist::create([
                'user_id' => $user->id,
                'therapist_name' => $therapist['name'],
                'therapist_section' => $therapist['section'],
                'therapist_phone' => $therapist['phone'],
            ]);
        }
    }
}
