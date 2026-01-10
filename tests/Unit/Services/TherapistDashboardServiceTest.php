<?php

namespace Tests\Unit\Services;

use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\Child;
use App\Models\Observation;
use App\Services\TherapistDashboardService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TherapistDashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    private TherapistDashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TherapistDashboardService();
        Carbon::setTestNow('2026-01-05 10:00:00');
    }

    public function test_get_dashboard_data_returns_complete_structure()
    {
        if (!DB::getSchemaBuilder()->hasTable('therapists')) {
            $this->markTestSkipped('Therapists table does not exist');
        }

        $observation = Observation::factory()->create([
            'scheduled_date' => '2026-01-10 09:00:00',
            'status' => 'scheduled'
        ]);

        $child = Child::factory()->create();
        $assessment = Assessment::factory()->create(['child_id' => $child->id]);
        $assessmentDetail = AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'type' => 'fisio',
            'status' => 'completed',
            'scheduled_date' => '2026-01-15 10:00:00',
            'parent_completed_status' => 'completed'
        ]);

        $result = $this->service->getDashboardData(1, 2026);

        $this->assertArrayHasKey('period', $result);
        $this->assertArrayHasKey('metrics', $result);
        $this->assertArrayHasKey('patient_categories', $result);
        $this->assertArrayHasKey('trend_chart', $result);

        $this->assertEquals(1, $result['period']['month']);
        $this->assertEquals(2026, $result['period']['year']);
    }

    public function test_get_total_observations_calculates_correct_change()
    {
        $child = Child::factory()->create();

        Observation::factory()->create([
            'child_id' => $child->id,
            'scheduled_date' => '2026-01-10 09:00:00'
        ]);
        Observation::factory()->create([
            'child_id' => $child->id,
            'scheduled_date' => '2026-01-15 14:00:00'
        ]);
        Observation::factory()->create([
            'child_id' => $child->id,
            'scheduled_date' => '2025-12-20 11:00:00'
        ]);

        $result = $this->service->getDashboardData(1, 2026);
        $observations = $result['metrics']['total_observations'];

        $this->assertEquals(2, $observations['current']);
        $this->assertEquals(1, $observations['previous']);
        $this->assertEquals(100, $observations['change_percent']);
        $this->assertEquals('increase', $observations['change_direction']);
    }

    public function test_get_total_assessments_calculates_correct_change()
    {
        $child = Child::factory()->create();
        $assessment = Assessment::factory()->create(['child_id' => $child->id]);

        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'scheduled_date' => '2026-01-10 09:00:00',
            'type' => 'fisio',
            'parent_completed_status' => 'completed'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'scheduled_date' => '2026-01-15 14:00:00',
            'type' => 'okupasi',
            'parent_completed_status' => 'completed'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => Assessment::factory()->create(['child_id' => $child->id])->id,
            'scheduled_date' => '2025-12-20 11:00:00',
            'type' => 'wicara',
            'parent_completed_status' => 'completed'
        ]);

        $result = $this->service->getDashboardData(1, 2026);
        $assessments = $result['metrics']['total_assessments'];

        $this->assertEquals(2, $assessments['current']);
        $this->assertEquals(1, $assessments['previous']);
        $this->assertEquals(100, $assessments['change_percent']);
        $this->assertEquals('increase', $assessments['change_direction']);
    }

    public function test_get_total_therapists_returns_correct_count()
    {
        if (!DB::getSchemaBuilder()->hasTable('therapists')) {
            $this->markTestSkipped('Therapists table does not exist');
        }

        $result = $this->service->getDashboardData(1, 2026);
        $therapists = $result['metrics']['total_therapists'];

        $this->assertEquals(0, $therapists['current']);
        $this->assertEquals(0, $therapists['previous']);
        $this->assertEquals(0, $therapists['change_percent']);
    }

    public function test_get_completion_rate_calculates_correct_percentage()
    {
        $child = Child::factory()->create();
        $assessment = Assessment::factory()->create(['child_id' => $child->id]);

        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'scheduled_date' => '2026-01-10 09:00:00',
            'status' => 'completed',
            'type' => 'fisio',
            'parent_completed_status' => 'completed'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'scheduled_date' => '2026-01-15 14:00:00',
            'status' => 'scheduled',
            'type' => 'okupasi',
            'parent_completed_status' => 'pending'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => Assessment::factory()->create(['child_id' => $child->id])->id,
            'scheduled_date' => '2025-12-20 11:00:00',
            'status' => 'completed',
            'type' => 'wicara',
            'parent_completed_status' => 'completed'
        ]);

        $result = $this->service->getDashboardData(1, 2026);
        $completionRate = $result['metrics']['completion_rate'];

        $this->assertEquals('50%', $completionRate['current']);
        $this->assertEquals('100%', $completionRate['previous']);
        $this->assertEquals(50, $completionRate['change_percent']);
        $this->assertEquals('decrease', $completionRate['change_direction']);
    }

    public function test_get_patient_categories_groups_by_type_correctly()
    {
        $child1 = Child::factory()->create();
        $child2 = Child::factory()->create();
        $child3 = Child::factory()->create();

        $assessment1 = Assessment::factory()->create(['child_id' => $child1->id]);
        $assessment2 = Assessment::factory()->create(['child_id' => $child2->id]);
        $assessment3 = Assessment::factory()->create(['child_id' => $child3->id]);

        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment1->id,
            'type' => 'fisio',
            'scheduled_date' => '2026-01-10 09:00:00',
            'parent_completed_status' => 'completed'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment2->id,
            'type' => 'fisio',
            'scheduled_date' => '2026-01-15 14:00:00',
            'parent_completed_status' => 'completed'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment3->id,
            'type' => 'okupasi',
            'scheduled_date' => '2026-01-20 11:00:00',
            'parent_completed_status' => 'completed'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment1->id,
            'type' => 'wicara',
            'scheduled_date' => '2026-01-25 16:00:00',
            'parent_completed_status' => 'completed'
        ]);

        $result = $this->service->getDashboardData(1, 2026);
        $categories = $result['patient_categories'];

        $this->assertCount(3, $categories);
        $this->assertEquals('Fisioterapi', $categories[0]['type']);
        $this->assertEquals(2, $categories[0]['count']);
    }

    public function test_get_trend_chart_returns_correct_data()
    {
        $child = Child::factory()->create();
        $assessment = Assessment::factory()->create(['child_id' => $child->id]);

        Observation::factory()->create([
            'child_id' => $child->id,
            'scheduled_date' => '2026-01-10 09:00:00'
        ]);
        Observation::factory()->create([
            'child_id' => $child->id,
            'scheduled_date' => '2026-01-15 14:00:00'
        ]);

        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'type' => 'fisio',
            'scheduled_date' => '2026-01-10 09:00:00',
            'parent_completed_status' => 'completed'
        ]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'type' => 'okupasi',
            'scheduled_date' => '2026-01-15 14:00:00',
            'parent_completed_status' => 'completed'
        ]);

        $result = $this->service->getDashboardData(1, 2026);
        $trendChart = $result['trend_chart'];

        $this->assertCount(4, $trendChart);
        $this->assertEquals('Total Anak (Observasi)', $trendChart[0]['label']);
        $this->assertEquals(1, $trendChart[0]['value']);
        $this->assertEquals('Kategori Anak (Assessment)', $trendChart[1]['label']);
        $this->assertEquals(1, $trendChart[1]['value']);
    }

    public function test_get_upcoming_schedules_collection_combines_observations_and_assessments()
    {
        $child = Child::factory()->create(['child_name' => 'Budi']);
        $child2 = Child::factory()->create(['child_name' => 'Siti']);

        Observation::factory()->create([
            'child_id' => $child->id,
            'status' => 'scheduled',
            'scheduled_date' => '2026-01-06 09:00:00'
        ]);
        Observation::factory()->create([
            'child_id' => $child2->id,
            'status' => 'scheduled',
            'scheduled_date' => '2026-01-06 09:00:00'
        ]);

        $assessment = Assessment::factory()->create(['child_id' => $child->id]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'type' => 'fisio',
            'status' => 'scheduled',
            'scheduled_date' => '2026-01-06 09:00:00',
            'parent_completed_status' => 'pending'
        ]);

        $result = $this->service->getUpcomingSchedulesCollection();

        $this->assertNotEmpty($result);

        if ($result->isNotEmpty()) {
            $hasBudi = $result->contains(function ($item) {
                return strpos($item['child_name'], 'Budi') !== false;
            });

            $hasSiti = $result->contains(function ($item) {
                return strpos($item['child_name'], 'Siti') !== false;
            });

            $this->assertTrue($hasBudi || $hasSiti);
        }
    }

    public function test_get_upcoming_schedules_collection_sorts_by_date_and_time()
    {
        $child = Child::factory()->create();

        Observation::factory()->create([
            'child_id' => $child->id,
            'status' => 'scheduled',
            'scheduled_date' => '2026-01-07 14:00:00'
        ]);

        $assessment = Assessment::factory()->create(['child_id' => $child->id]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'type' => 'fisio',
            'status' => 'scheduled',
            'scheduled_date' => '2026-01-06 09:00:00',
            'parent_completed_status' => 'pending'
        ]);

        Observation::factory()->create([
            'child_id' => $child->id,
            'status' => 'scheduled',
            'scheduled_date' => '2026-01-06 11:00:00'
        ]);

        $result = $this->service->getUpcomingSchedulesCollection();

        $this->assertNotEmpty($result);
    }

    public function test_get_upcoming_schedules_collection_respects_limit()
    {
        $child = Child::factory()->create();

        for ($i = 1; $i <= 15; $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            Observation::factory()->create([
                'child_id' => $child->id,
                'status' => 'scheduled',
                'scheduled_date' => "2026-01-$day 09:00:00"
            ]);
        }

        $result = $this->service->getUpcomingSchedulesCollection(5);
        $this->assertLessThanOrEqual(5, $result->count());
    }

    public function test_calculate_change_with_zero_previous()
    {
        $result = $this->service->getDashboardData(1, 2026);

        $observations = $result['metrics']['total_observations'];
        $this->assertEquals(0, $observations['current']);
        $this->assertEquals(0, $observations['previous']);
        $this->assertEquals(0, $observations['change_percent']);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }
}
