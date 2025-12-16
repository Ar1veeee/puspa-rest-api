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
        $this->seedTherapist();
        $this->seedAssessor();
    }

    private function seedTherapist()
    {
        $therapists = [
            ['name' => 'Nindya Zahri', 'username' => 'fisioNindya', 'email' => 'nindya@terapis.com', 'password' => Hash::make('Nindya123.'), 'phone' => '089299886188', 'section' => 'fisio'],
            ['name' => 'Alfian Plumek', 'username' => 'okupasiAlfian', 'email' => 'alfian@terapis.com', 'password' => Hash::make('Alfian123.'), 'phone' => '089299881199', 'section' => 'okupasi'],
            ['name' => 'Rano Karno', 'username' => 'wicaraRano', 'email' => 'rano@terapis.com', 'password' => Hash::make('Rano123.'), 'phone' => '089299224288', 'section' => 'wicara'],
            ['name' => 'Adit Tolongin', 'username' => 'paedagogAdit', 'email' => 'adit@terapis.com', 'password' => Hash::make('Adit123.'), 'phone' => '089211096188', 'section' => 'paedagog'],
        ];

        foreach ($therapists as $therapist) {
            $user = User::create([
                'username' => $therapist['username'],
                'email' => $therapist['email'],
                'password' => $therapist['password'],
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
            ]);

            Therapist::create([
                'user_id' => $user->id,
                'therapist_name' => $therapist['name'],
                'therapist_section' => $therapist['section'],
                'therapist_phone' => $therapist['phone'],
                'therapist_birth_date' => Carbon::now()->subYears(fake()->numberBetween(22, 40)),
            ]);

            $user->assignRole('terapis');
        }
    }

    private function seedAssessor()
    {
        $assessors = [
            ['name' => 'Alief Arifun', 'username' => 'okupasiAlief', 'email' => 'alief@terapis.com', 'password' => Hash::make('Alief123.'), 'phone' => '089299886565', 'section' => 'okupasi'],
            ['name' => 'Zamzam Berli', 'username' => 'fisioZamzam', 'email' => 'zamzam@admin.com', 'password' => Hash::make('Zamzam123.'), 'phone' => '089522001901', 'section' => 'fisio'],
            ['name' => 'Ema Emi', 'username' => 'wicaraEma', 'email' => 'ema@admin.com', 'password' => Hash::make('Ema1234.'), 'phone' => '089522001945', 'section' => 'wicara'],
            ['name' => 'Rendra Prasetyo', 'username' => 'paedagogRendra', 'email' => 'rendra@admin.com', 'password' => Hash::make('Rendra123.'), 'phone' => '089522004949', 'section' => 'paedagog'],
        ];

        foreach ($assessors as $assessor) {
            $user = User::create([
                'username' => $assessor['username'],
                'email' => $assessor['email'],
                'password' => $assessor['password'],
                'is_active' => true,
                'email_verified_at' => Carbon::now(),
            ]);

            Therapist::create([
                'user_id' => $user->id,
                'therapist_name' => $assessor['name'],
                'therapist_section' => $assessor['section'],
                'therapist_phone' => $assessor['phone'],
                'therapist_birth_date' => Carbon::now()->subYears(fake()->numberBetween(22, 40)),
            ]);

            $user->assignRole('asesor');
        }
    }
}
