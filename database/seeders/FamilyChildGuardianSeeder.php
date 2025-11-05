<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\Family;
use App\Models\Guardian;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class FamilyChildGuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $now = Carbon::now();

        for ($i = 0; $i < 10; $i++) {
            $family = Family::create([
                'id' => Str::ulid(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $guardianEmail = $faker->unique()->safeEmail;
            $user = User::create([
                'id' => Str::ulid(),
                'username' => $faker->unique()->userName,
                'email' => $guardianEmail,
                'password' => Hash::make('Password123.'),
                'email_verified_at' => $now,
                'role' => 'User',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            Guardian::create([
                'id' => Str::ulid(),
                'family_id' => $family->id,
                'user_id' => $user->id,
                'temp_email' => $guardianEmail,
                'guardian_type' => $faker->randomElement(['ibu', 'ayah']),
                'guardian_identity_number' => $faker->nik(),
                'guardian_name' => $faker->name,
                'guardian_phone' => $faker->phoneNumber,
                'guardian_birth_date' => $faker->dateTimeBetween('-50 years', '-30 years')->format('Y-m-d'),
                'guardian_occupation' => $faker->jobTitle,
                'relationship_with_child' => 'Orang Tua Kandung',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            Child::create([
                'id' => Str::ulid(),
                'family_id' => $family->id,
                'child_name' => $faker->firstName . ' ' . $faker->lastName,
                'child_birth_place' => $faker->city,
                'child_birth_date' => $faker->dateTimeBetween('-15 years', '-3 years')->format('Y-m-d'),
                'child_address' => $faker->address,
                'child_complaint' => $faker->sentence(10),
                'child_school' => 'TK ' . $faker->lastName,
                'child_service_choice' => $faker->randomElement(['okupasi', 'fisio', 'wicara', 'paedagog']),
                'child_religion' => $faker->randomElement(['islam','kristen','katolik','hindu','budha','konghucu','lainnya']),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
