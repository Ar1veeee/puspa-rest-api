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
use Carbon\Carbon;
use Faker\Factory as Faker;

class ObservationAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $children = Child::all();
        $admins = Admin::all();
        $therapists = Therapist::all();
        $questions = ObservationQuestion::all();

        if ($children->isEmpty() || $admins->isEmpty() || $therapists->isEmpty() || $questions->isEmpty()) {
            $this->command->warn('Tidak ada data pendukung. Melewatkan seeder.');
            return;
        }

        $now = Carbon::now();

        $months = [];
        for ($i = 0; $i < 3; $i++) {
            $date = $now->copy()->subMonths($i);
            $months[] = [
                'start' => $date->copy()->startOfMonth(),
                'end'   => $date->copy()->endOfMonth(),
            ];
        }

        foreach ($children as $child) {
            $age = Carbon::parse($child->child_birth_date)->age;
            $ageCategory = match (true) {
                $age <= 5 => 'balita',
                $age <= 12 => 'anak-anak',
                $age <= 17 => 'remaja',
                default => 'lainya',
            };

            $relevantQuestions = $questions->where('age_category', strtolower($ageCategory));
            if ($relevantQuestions->isEmpty()) continue;

            $selectedMonth = $faker->randomElement($months);


            $scheduledDateRaw = $faker->dateTimeBetween($selectedMonth['start'], $selectedMonth['end']);
            $scheduledDate = Carbon::instance($scheduledDateRaw);

            $status = $faker->randomElement(['pending', 'scheduled', 'completed']);

            $completedTime = $status === 'completed'
                ? $scheduledDate->copy()->addHours(rand(1, 8))->format('H:i:s')
                : '00:00:00';

            $observation = Observation::create([
                'child_id' => $child->id,
                'admin_id' => $admins->random()->id,
                'therapist_id' => $therapists->random()->id,
                'scheduled_date' => $scheduledDate,
                'age_category' => $ageCategory,
                'status' => $status,
                'completed_at' => $completedTime,
                'is_continued_to_assessment' => $faker->boolean(70),
                'created_at' => $scheduledDate->copy()->subDays(rand(1, 5)),
                'updated_at' => $scheduledDate,
            ]);

            $totalScore = 0;
            foreach ($relevantQuestions as $question) {
                $answer = $faker->boolean(60);
                $scoreEarned = $answer ? $question->score : 0;
                $totalScore += $scoreEarned;

                ObservationAnswer::create([
                    'observation_id' => $observation->id,
                    'question_id' => $question->id,
                    'answer' => $answer,
                    'score_earned' => $scoreEarned,
                    'note' => $faker->optional(0.4)->sentence,
                ]);
            }

            $observation->update([
                'total_score' => $totalScore,
                'conclusion' => $faker->paragraph(3),
                'recommendation' => $faker->paragraph(2),
            ]);

            if ($observation->is_continued_to_assessment) {
                $assessment = Assessment::create([
                    'observation_id' => $observation->id,
                    'child_id' => $child->id,
                    'created_at' => $scheduledDate,
                    'updated_at' => $scheduledDate,
                ]);

                $assessmentScheduled = $scheduledDate->copy()->addDays(rand(7, 21));

                $completedAtUmum = null;
                if ($assessmentScheduled->lte($now) && $faker->boolean(70)) {
                    $maxCompletionDate = min(
                        $assessmentScheduled->copy()->addDays(7)->timestamp,
                        $now->timestamp
                    );
                    $completedAtUmum = $faker->dateTimeBetween(
                        $assessmentScheduled->copy()->addHours(1),
                        Carbon::createFromTimestamp($maxCompletionDate)
                    );
                }

                AssessmentDetail::create([
                    'assessment_id' => $assessment->id,
                    'type' => 'umum',
                    'admin_id' => $admins->random()->id,
                    'therapist_id' => $therapists->random()->id,
                    'status' => $completedAtUmum ? 'completed' : 'scheduled',
                    'scheduled_date' => $assessmentScheduled,
                    'completed_at' => $completedAtUmum,
                    'created_at' => $scheduledDate,
                    'updated_at' => $scheduledDate,
                ]);

                $otherTypes = ['fisio', 'okupasi', 'wicara', 'paedagog'];
                $selectedTypes = $faker->randomElements($otherTypes, $faker->numberBetween(1, 3));

                foreach ($selectedTypes as $type) {
                    $typeScheduled = $scheduledDate->copy()->addDays(rand(10, 40));

                    $completedAtType = null;
                    if ($typeScheduled->lte($now) && $faker->boolean(60)) {
                        $maxCompletionDate = min(
                            $typeScheduled->copy()->addDays(14)->timestamp,
                            $now->timestamp
                        );
                        $completedAtType = $faker->dateTimeBetween(
                            $typeScheduled->copy()->addHours(3),
                            Carbon::createFromTimestamp($maxCompletionDate)
                        );
                    }

                    AssessmentDetail::create([
                        'assessment_id' => $assessment->id,
                        'type' => $type,
                        'admin_id' => $admins->random()->id,
                        'therapist_id' => $therapists->random()->id,
                        'status' => $completedAtType ? 'completed' : 'scheduled',
                        'scheduled_date' => $typeScheduled,
                        'completed_at' => $completedAtType,
                        'created_at' => $scheduledDate,
                        'updated_at' => $scheduledDate,
                    ]);
                }
            }
        }
    }
}
