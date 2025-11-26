<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Guardian, User, Admin, Therapist, Family, Child, Observation, Assessment, AssessmentDetail};
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting Dashboard Data Seeder...');

        $this->seedOwner();
        $admins = $this->seedAdmins();
        $therapists = $this->seedTherapists();
        $testTherapist = $this->seedTestTherapist();
        $children = $this->seedFamiliesAndChildren();

        $this->seedObservations($children, $therapists, $testTherapist, $admins);
        $this->seedAssessments($therapists, $admins);

        $this->command->info('✅ Dashboard Data Seeder Completed!');
        $this->printSummary();
    }

    // ===============================================================
    // 1. OWNER
    // ===============================================================
    private function seedOwner(): void
    {
        User::factory()->owner()->create([
            'username' => 'owner',
            'email' => 'owner@example.com',
        ]);
    }

    // ===============================================================
    // 2. ADMINS
    // ===============================================================
    private function seedAdmins()
    {
        $admins = collect();

        for ($i = 1; $i <= 5; $i++) {
            $adminUser = User::factory()->admin()->create([
                'username' => "admin{$i}",
                'email' => "admin{$i}@example.com",
            ]);

            $admins->push(
                Admin::factory()->create([
                    'user_id' => $adminUser->id,
                    'admin_name' => "Admin $i",
                ])
            );
        }

        return $admins;
    }

    // ===============================================================
    // 3. THERAPISTS
    // ===============================================================
    private function seedTherapists()
    {
        $therapists = collect();
        $sections = ['okupasi', 'fisio', 'wicara', 'paedagog'];

        foreach ($sections as $section) {
            for ($i = 1; $i <= 5; $i++) {
                $therapistUser = User::factory()->therapist()->create([
                    'username' => strtolower($section) . "_therapist{$i}",
                    'email' => strtolower($section) . ".therapist{$i}@example.com",
                ]);

                $therapists->push(
                    Therapist::factory()->section($section)->create([
                        'user_id' => $therapistUser->id,
                        'therapist_name' => ucfirst($section) . " Therapist $i",
                    ])
                );
            }
        }

        return $therapists;
    }

    private function seedTestTherapist()
    {
        $testUser = User::factory()->therapist()->create([
            'username' => 'therapist',
            'email' => 'therapist@example.com',
        ]);

        return Therapist::factory()->section('wicara')->create([
            'user_id' => $testUser->id,
            'therapist_name' => 'Test Therapist',
        ]);
    }

    // ===============================================================
    // 5. FAMILIES & CHILDREN
    // ===============================================================
    private function seedFamiliesAndChildren()
    {
        $children = collect();

        for ($i = 1; $i <= 100; $i++) {
            $family = Family::factory()->create();

            Guardian::factory()->create([
                'family_id' => $family->id,
                'guardian_name' => "Parent $i",
                'guardian_type' => fake()->randomElement(['ayah', 'ibu', 'wali']),
            ]);

            $children->push(
                Child::factory()->create([
                    'family_id' => $family->id,
                    'child_name' => "Child $i",
                ])
            );
        }

        return $children;
    }


    // ===============================================================
    // 6. OBSERVATIONS
    // ===============================================================
    private function seedObservations($children, $therapists, $testTherapist, $admins): void
    {
        $now = now();

        for ($month = 0; $month < 6; $month++) {
            $monthDate = $now->copy()->subMonths($month);
            $start = $monthDate->copy()->startOfMonth();
            $end = $monthDate->copy()->endOfMonth();

            $count = rand(150, 250);

            $this->command->info("  → Month {$monthDate->format('M Y')}: Creating $count observations");

            for ($i = 0; $i < $count; $i++) {
                $status = $this->getRandomObservationStatus();
                $createdAt = fake()->dateTimeBetween($start, $end);
                $scheduleStart = Carbon::parse($createdAt);
                $scheduleEnd = $scheduleStart->copy()->addDays(14);

                $adminId = null;
                $therapistId = null;

                if ($status === 'scheduled') {
                    $adminId = $admins->random()->id;
                    $therapistId = null;
                } elseif ($status === 'completed') {
                    $adminId = $admins->random()->id;
                    $therapist = fake()->boolean(80) ? $therapists->random() : $testTherapist;
                    $therapistId = $therapist->id;
                }

                Observation::create([
                    'child_id' => $children->random()->id,
                    'admin_id' => $adminId,
                    'therapist_id' => $therapistId,
                    'scheduled_date' => $status !== 'pending'
                        ? fake()->dateTimeBetween($scheduleStart, $scheduleEnd)
                        : null,
                    'age_category' => fake()->randomElement(['balita', 'anak-anak', 'remaja', 'lainya']),
                    'total_score' => $status === 'completed' ? rand(50, 100) : null,
                    'conclusion' => $status === 'completed' ? fake()->paragraph() : null,
                    'recommendation' => $status === 'completed' ? fake()->paragraph() : null,
                    'status' => $status,
                    'completed_at' => $status === 'completed'
                        ? fake()->time()
                        : '00:00:00',
                    'is_continued_to_assessment' => $status === 'completed' ? fake()->boolean(60) : false,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }

    private function getRandomObservationStatus(): string
    {
        $r = rand(1, 100);

        if ($r <= 20) return 'pending';
        if ($r <= 50) return 'scheduled';
        return 'completed';
    }

    // ===============================================================
    // 7. ASSESSMENTS
    // ===============================================================
    private function seedAssessments($therapists, $admins)
    {
        $completedObs = Observation::where('status', 'completed')
            ->where('is_continued_to_assessment', true)
            ->get();

        foreach ($completedObs as $obs) {
            $assessment = Assessment::create([
                'observation_id' => $obs->id,
                'child_id' => $obs->child_id,
                'created_at' => $obs->created_at,
                'updated_at' => $obs->updated_at,
            ]);

            $types = fake()->randomElements(['fisio', 'okupasi', 'wicara', 'paedagog'], rand(1, 3));

            foreach ($types as $type) {
                $therapist = $therapists->where('therapist_section', $type)->random();
                $admin = $admins->random();
                $status = fake()->randomElement(['pending', 'scheduled', 'completed']);

                $parentStatus = fake()->randomElement(['pending', 'completed']);

                $rangeStart = Carbon::parse($obs->created_at);
                $rangeEnd = $rangeStart->copy()->addWeeks(2);

                AssessmentDetail::create([
                    'assessment_id' => $assessment->id,
                    'type' => $type,
                    'admin_id' => $admin->id,
                    'therapist_id' => $therapist->id,
                    'status' => $status,
                    'scheduled_date' => $status !== 'pending'
                        ? fake()->dateTimeBetween($rangeStart, $rangeEnd)
                        : null,
                    'completed_at' => $status === 'completed'
                        ? fake()->dateTimeBetween($rangeStart, $rangeEnd)
                        : null,
                    'parent_completed_status' => $parentStatus,
                    'parent_completed_at' => $parentStatus === 'completed'
                        ? fake()->dateTimeBetween($rangeStart, $rangeEnd)
                        : null,
                    'created_at' => $obs->created_at,
                    'updated_at' => $obs->updated_at,
                ]);
            }
        }
    }

    private function printSummary(): void
    {
        $this->command->info("\n📊 Data Summary");
        $this->command->table(
            ['Entity', 'Count'],
            [
                ['Users', User::count()],
                ['Admins', Admin::count()],
                ['Therapists', Therapist::count()],
                ['Families', Family::count()],
                ['Children', Child::count()],
                ['Observations', Observation::count()],
                ['Assessments', Assessment::count()],
                ['Assessment Details', AssessmentDetail::count()],
            ]
        );
    }
}
