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

        $admins = Admin::all();
        $therapists = Therapist::all();
        $questions = ObservationQuestion::all();

        if ($admins->isEmpty() || $therapists->isEmpty() || $questions->isEmpty()) {
            $this->command->warn('Data admin, therapist, atau question tidak cukup. Melewatkan seeder.');
            return;
        }

        $children = Child::with(['family.guardians'])
            ->has('family')
            ->whereHas('family.guardians')
            ->get();

        if ($children->isEmpty()) {
            $this->command->warn('Tidak ada anak dengan family dan guardian yang valid. Jalankan FamilySeeder, GuardianSeeder, dan ChildSeeder terlebih dahulu.');
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

            $birthDate = Carbon::parse($child->child_birth_date);
            $age = $birthDate->age;

            $ageCategory = match (true) {
                $age <= 5   => 'balita',
                $age <= 12  => 'anak-anak',
                $age <= 17  => 'remaja',
                default     => 'lainya',
            };

            $relevantQuestions = $questions->where('age_category', strtolower($ageCategory));
            if ($relevantQuestions->isEmpty()) {
                continue;
            }

            $selectedMonth = $faker->randomElement($months);
            $scheduledDate = Carbon::parse(
                $faker->dateTimeBetween($selectedMonth['start'], $selectedMonth['end'])
            );

            $status = $faker->randomElement(['pending', 'scheduled', 'completed']);

            $completedTime = '00:00:00';
            if ($status === 'completed') {
                $completedTime = $scheduledDate->copy()
                    ->addHours(rand(1, 6))
                    ->addMinutes(rand(0, 59))
                    ->format('H:i:s');
            }

            $observation = Observation::create([
                'child_id'     => $child->id,
                'admin_id'     => $admins->random()->id,
                'therapist_id' => $therapists->random()->id,
                'scheduled_date' => $scheduledDate,
                'age_category'  => $ageCategory,
                'status'        => $status,
                'completed_at'  => $completedTime,
                'is_continued_to_assessment' => $faker->boolean(70),
                'created_at'    => $scheduledDate->copy()->subDays(rand(1, 7)),
                'updated_at'    => $scheduledDate,
            ]);

            $totalScore = 0;
            foreach ($relevantQuestions as $question) {
                $answer = $faker->boolean(65);
                $scoreEarned = $answer ? ($question->score ?? 1) : 0;
                $totalScore += $scoreEarned;

                ObservationAnswer::create([
                    'observation_id' => $observation->id,
                    'question_id'    => $question->id,
                    'answer'         => $answer,
                    'score_earned'   => $scoreEarned,
                    'note'           => $faker->optional(0.35)->sentence(10),
                ]);
            }

            $observation->update([
                'total_score'    => $totalScore,
                'conclusion'     => $faker->paragraphs(3, true),
                'recommendation' => $faker->paragraphs(2, true),
            ]);

            if ($observation->is_continued_to_assessment) {
                $assessment = Assessment::create([
                    'observation_id' => $observation->id,
                    'child_id'       => $child->id,
                    'created_at'     => $scheduledDate,
                    'updated_at'     => $scheduledDate,
                ]);

                $assessmentScheduled = $scheduledDate->copy()->addDays(rand(7, 21));
                $completedAtUmum = null;
                $statusUmum = 'scheduled';

                if ($assessmentScheduled->lte($now) && $faker->boolean(75)) {
                    $completedAtUmum = $faker->dateTimeBetween(
                        $assessmentScheduled->copy()->addHours(1),
                        $assessmentScheduled->copy()->addDays(7)->lt($now) ? $assessmentScheduled->copy()->addDays(7) : $now
                    );
                    $statusUmum = 'completed';
                }

                AssessmentDetail::create([
                    'assessment_id'  => $assessment->id,
                    'type'           => 'umum',
                    'admin_id'       => $admins->random()->id,
                    'therapist_id'   => $therapists->random()->id,
                    'status'         => $statusUmum,
                    'scheduled_date' => $assessmentScheduled,
                    'completed_at'   => $completedAtUmum,
                    'created_at'     => $scheduledDate,
                    'updated_at'     => $scheduledDate,
                ]);

                $otherTypes = ['fisio', 'okupasi', 'wicara', 'paedagog'];
                $selectedTypes = $faker->randomElements($otherTypes, $faker->numberBetween(1, 3));

                foreach ($selectedTypes as $type) {
                    $typeScheduled = $scheduledDate->copy()->addDays(rand(10, 45));
                    $completedAtType = null;
                    $statusType = 'scheduled';

                    if ($typeScheduled->lte($now) && $faker->boolean(60)) {
                        $completedAtType = $faker->dateTimeBetween(
                            $typeScheduled->copy()->addHours(2),
                            $typeScheduled->copy()->addDays(14)->lt($now) ? $typeScheduled->copy()->addDays(14) : $now
                        );
                        $statusType = 'completed';
                    }

                    AssessmentDetail::create([
                        'assessment_id'  => $assessment->id,
                        'type'           => $type,
                        'admin_id'       => $admins->random()->id,
                        'therapist_id'   => $therapists->random()->id,
                        'status'         => $statusType,
                        'scheduled_date' => $typeScheduled,
                        'completed_at'   => $completedAtType,
                        'created_at'     => $scheduledDate,
                        'updated_at'     => $scheduledDate,
                    ]);
                }
            }
        }
    }
}
