<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $this->call([
            RolePermissionSeeder::class,
            OwnerSeeder::class,
            AdminSeeder::class,
            TherapistSeeder::class,

            // Observation Questions
            ObservationQuestionSeeder::class,

            // Assessor Assessment Questions
            OccupationalAssessmentQuestionSeeder::class,
            PedagogicalAssessmentQuestionSeeder::class,
            SpeechAssessmentQuestionSeeder::class,
            PhysioAssessmentQuestionSeeder::class,

            // Parent Assessment Questions
            ParentGeneralAssessmentQuestionSeeder::class,
            ParentOccupationalAssessmentQuestionSeeder::class,
            ParentSpeechAssessmentQuestionSeeder::class,
            ParentPedagogicalAssessmentQuestionSeeder::class,
            ParentPhysioAssessmentQuestionSeeder::class,
        ]);
    }
}
