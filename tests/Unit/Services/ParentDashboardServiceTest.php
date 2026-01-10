<?php

namespace Tests\Unit\Services;

use App\Models\Child;
use App\Models\Family;
use App\Models\Observation;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Services\ParentDashboardService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ParentDashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    private ParentDashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ParentDashboardService();
        Carbon::setTestNow('2026-01-05 10:00:00');
        app()->setLocale('id');
    }

    /** @test */
    public function get_stats_returns_correct_data_with_children()
    {
        $family = Family::factory()->create();

        Child::factory()->create([
            'family_id' => $family->id,
            'created_at' => '2025-11-01'
        ]);

        Child::factory()->count(3)->create([
            'family_id' => $family->id,
            'created_at' => '2026-01-03'
        ]);

        $childIds = Child::where('family_id', $family->id)->pluck('id');

        Observation::factory()->count(20)->create([
            'child_id' => $childIds->random(),
            'created_at' => '2026-01-02'
        ]);

        Observation::factory()->count(5)->create([
            'child_id' => $childIds->random(),
            'created_at' => '2025-11-30'
        ]);

        DB::shouldReceive('table')->andReturnSelf();
        DB::shouldReceive('join')->andReturnSelf();
        DB::shouldReceive('whereIn')->andReturnSelf();
        DB::shouldReceive('selectRaw')->andReturnSelf();
        DB::shouldReceive('first')->once()->andReturn(
            (object)['total' => 30, 'last_month' => 10]
        );

        $result = $this->service->getStats($family->id);

        $this->assertEquals(4, $result['total_children']);
        $this->assertEquals(300.0, $result['total_children_percentage']['value']);

        $this->assertEquals(25, $result['total_observations']);
        $this->assertEquals(400.0, $result['total_observations_percentage']['value']);

        $this->assertEquals(30, $result['total_assessments']);
        $this->assertEquals(200.0, $result['total_assessments_percentage']['value']);
    }

    /** @test */
    public function get_stats_returns_empty_stats_when_no_children()
    {
        $result = $this->service->getStats('non-existent');
        $this->assertEquals(0, $result['total_children']);
        $this->assertEquals(0, $result['total_children_percentage']['value']);
        $this->assertEquals('neutral', $result['total_children_percentage']['direction']);
        $this->assertEquals(0, $result['total_observations']);
        $this->assertEquals(0, $result['total_assessments']);
    }

    /** @test */
    public function get_chart_data_returns_12_months_trend()
    {
        $family = Family::factory()->create();

        Child::factory()->create([
            'family_id' => $family->id,
            'created_at' => '2025-07-01'
        ]);

        Observation::factory()->count(3)->create([
            'child_id' => Child::first()->id,
            'created_at' => '2025-11-15'
        ]);

        DB::shouldReceive('table')->andReturnSelf();
        DB::shouldReceive('join')->andReturnSelf();
        DB::shouldReceive('whereIn')->andReturnSelf();
        DB::shouldReceive('whereBetween')->andReturnSelf();
        DB::shouldReceive('selectRaw')->andReturnSelf();
        DB::shouldReceive('groupBy')->andReturnSelf();
        DB::shouldReceive('pluck')->once()->andReturn(
            collect(['2025-11' => 4])
        );

        $result = $this->service->getChartData($family->id);

        $this->assertCount(12, $result);
        $this->assertEquals('Feb 2025', $result[0]['month']);
        $this->assertEquals('Nov 2025', $result[9]['month']);
        $this->assertEquals(1, $result[9]['total_children']);
        $this->assertEquals(3, $result[9]['total_observations']);
        $this->assertEquals(4, $result[9]['total_assessments']);
        $this->assertEquals('Jan 2026', $result[11]['month']);
        $this->assertEquals(1, $result[11]['total_children']);
    }

    /** @test */
    public function get_chart_data_returns_empty_array_when_no_children()
    {
        $result = $this->service->getChartData('no-children');
        $this->assertEmpty($result);
    }

    /** @test */
    public function get_upcoming_schedules_returns_combined_observation_and_assessment_schedules()
    {
        $family = Family::factory()->create();
        $child = Child::factory()->create(['family_id' => $family->id]);

        Observation::factory()->create([
            'child_id' => $child->id,
            'status' => 'scheduled',
            'scheduled_date' => now()->addDays(5)
        ]);

        $assessment = Assessment::factory()->create(['child_id' => $child->id]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'type' => 'fisio',
            'status' => 'scheduled',
            'scheduled_date' => now()->addDays(3),
            'parent_completed_status' => 'pending'
        ]);

        $result = $this->service->getUpcomingSchedules($family->id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertEquals('observation', $result->firstWhere('type', 'observation')['type']);
        $this->assertEquals('assessment', $result->firstWhere('type', 'assessment')['type']);
        $this->assertEquals('Assessment Fisio', $result->firstWhere('type', 'assessment')['type_label']);
    }

    /** @test */
    public function get_upcoming_schedules_respects_type_filter()
    {
        $family = Family::factory()->create();
        $child = Child::factory()->create(['family_id' => $family->id]);

        Observation::factory()->create([
            'child_id' => $child->id,
            'status' => 'scheduled',
            'scheduled_date' => now()->addDays(2)
        ]);

        $assessment = Assessment::factory()->create(['child_id' => $child->id]);
        AssessmentDetail::factory()->create([
            'assessment_id' => $assessment->id,
            'type' => 'wicara',
            'status' => 'scheduled',
            'scheduled_date' => now()->addDays(4),
            'parent_completed_status' => 'pending'
        ]);

        $resultObservation = $this->service->getUpcomingSchedules($family->id, ['type' => 'observation']);
        $this->assertCount(1, $resultObservation);

        $resultAssessment = $this->service->getUpcomingSchedules($family->id, ['type' => 'assessment']);
        $this->assertCount(1, $resultAssessment);
    }

    /** @test */
    public function get_upcoming_schedules_applies_search_filter()
    {
        $family = Family::factory()->create();
        $child1 = Child::factory()->create(['family_id' => $family->id, 'child_name' => 'Budi']);
        $child2 = Child::factory()->create(['family_id' => $family->id, 'child_name' => 'Siti']);

        Observation::factory()->create([
            'child_id' => $child1->id,
            'status' => 'scheduled',
            'scheduled_date' => now()->addDays(1)
        ]);

        Observation::factory()->create([
            'child_id' => $child2->id,
            'status' => 'scheduled',
            'scheduled_date' => now()->addDays(2)
        ]);

        $result = $this->service->getUpcomingSchedules($family->id, ['search' => 'budi']);

        $this->assertCount(1, $result);
        $this->assertEquals('Budi', $result->first()['child_name']);
    }

    /** @test */
    public function get_upcoming_schedules_returns_empty_collection_when_no_children()
    {
        $result = $this->service->getUpcomingSchedules('empty-family');
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }
}
