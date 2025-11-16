<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\Child;
use App\Models\Observation;
use App\Models\ObservationAnswer;
use App\Models\ObservationQuestion;
use App\Models\Therapist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ObservationAssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $now = Carbon::now();

        $children = Child::all();
        $admins = Admin::all();
        $therapists = Therapist::all();
        $questions = ObservationQuestion::all();

        if ($children->isEmpty() || $admins->isEmpty() || $therapists->isEmpty() || $questions->isEmpty()) {
            $this->command->warn('Tidak ada data Child, Admin, Therapist, atau ObservationQuestion. Melewatkan ObservationAssessmentSeeder.');
            return;
        }

        foreach ($children as $child) {
            $age = Carbon::parse($child->child_birth_date)->age;
            $ageCategory = 'lainya'; // Default
            if ($age <= 5) {
                $ageCategory = 'balita';
            } elseif ($age > 5 && $age <= 12) {
                $ageCategory = 'anak-anak';
            } elseif ($age > 12 && $age <= 17) {
                $ageCategory = 'remaja';
            }

            $relevantQuestions = $questions->where('age_category', strtolower($ageCategory));

            if ($relevantQuestions->isEmpty()) {
                continue;
            }

            $observation = Observation::create([
                'child_id' => $child->id,
                'admin_id' => $admins->random()->id,
                'therapist_id' => $therapists->random()->id,
                'scheduled_date' => $now->addDays(rand(1, 10)),
                'age_category' => $ageCategory,
                'status' => 'completed',
                'completed_at' => $now->addHours(rand(1, 5)),
                'is_continued_to_assessment' => $faker->boolean(70),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $totalScore = 0;

            foreach ($relevantQuestions as $question) {
                $answer = $faker->boolean(50);
                $scoreEarned = $answer ? $question->score : 0;
                $totalScore += $scoreEarned;

                ObservationAnswer::create([
                    'observation_id' => $observation->id,
                    'question_id' => $question->id,
                    'answer' => $answer,
                    'score_earned' => $scoreEarned,
                    'note' => $faker->optional()->sentence,
                ]);
            }

            $observation->update([
                'total_score' => $totalScore,
                'conclusion' => $faker->sentence(15),
                'recommendation' => $faker->sentence(10),
            ]);

            $validTypes = ['fisio','okupasi', 'wicara', 'paedagog'];

            if ($observation->is_continued_to_assessment) {
                $assessment = Assessment::create([
                    'observation_id' => $observation->id,
                    'child_id' => $child->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                AssessmentDetail::create([
                    'assessment_id' => $assessment->id,
                    'type' => $validTypes[array_rand($validTypes)],
                    'admin_id' => $admins->random()->id,
                    'therapist_id' => null,
                    'status' => 'scheduled',
                    'scheduled_date' => $now->addDays(rand(11, 20)),
                    'completed_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
