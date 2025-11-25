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
        $this->call([
            OwnerSeeder::class,
            AdminSeeder::class,
            TherapistSeeder::class,

            ObservationQuestionSeeder::class,

            FamilyChildGuardianSeeder::class,
            ObservationAssessmentSeeder::class,

            OccupationalAssessmentQuestionSeeder::class,
            PedagogicalAssessmentQuestionSeeder::class,
            SpeechAssessmentQuestionSeeder::class,
            PhysioAssessmentQuestionSeeder::class,

            ParentGeneralAssessmentQuestionSeeder::class,
            ParentOccupationalAssessmentQuestionSeeder::class,
            ParentSpeechAssessmentQuestionSeeder::class,
            ParentPedagogicalAssessmentQuestionSeeder::class,
            ParentPhysioAssessmentQuestionSeeder::class,

            DummyDataSeeder::class,
        ]);
    }
}
