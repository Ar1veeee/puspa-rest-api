<?php

namespace Tests\Unit\Services;

use App\Http\Resources\TodayAssessmentScheduleResource;
use App\Services\AdminDashboardService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminDashboardServiceTest extends TestCase
{
    private AdminDashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminDashboardService();

        Carbon::setTestNow('2026-01-05 10:00:00');
        app()->setLocale('id');
    }

    /** @test */
    public function get_dashboard_data_returns_correct_structure_and_values()
    {
        DB::shouldReceive('table')->andReturnSelf();
        DB::shouldReceive('join')->andReturnSelf();
        DB::shouldReceive('where')->andReturnSelf();
        DB::shouldReceive('whereDate')->andReturnSelf();
        DB::shouldReceive('whereIn')->andReturnSelf();
        DB::shouldReceive('whereExists')->andReturnSelf();
        DB::shouldReceive('orWhereExists')->andReturnSelf();
        DB::shouldReceive('groupBy')->andReturnSelf();
        DB::shouldReceive('distinct')->andReturnSelf();
        DB::shouldReceive('select')->andReturnSelf();

        DB::shouldReceive('raw')->andReturn('raw_expression');

        DB::shouldReceive('count')
            ->times(3)
            ->andReturn(20, 12, 85);

        $categories = collect([
            (object)['type' => 'fisio', 'count' => 40],
            (object)['type' => 'wicara', 'count' => 25],
            (object)['type' => 'okupasi', 'count' => 15],
            (object)['type' => 'paedagog', 'count' => 5],
        ]);

        DB::shouldReceive('get')->once()->andReturn($categories);

        $result = $this->service->getDashboardData('2026-01-05');

        $this->assertEquals('2026-01-05', $result['date']['current']);
        $this->assertEquals('Senin, 05 Januari 2026', $result['date']['formatted']);

        $this->assertEquals(20, $result['metrics']['assessment_today']);
        $this->assertEquals(12, $result['metrics']['observation_today']);
        $this->assertEquals(85, $result['metrics']['active_patients']);

        $this->assertCount(4, $result['patient_categories']);
        $this->assertEquals('Fisio', $result['patient_categories'][0]['type']);
        $this->assertEquals(47.1, $result['patient_categories'][0]['percentage']);
        $this->assertEquals('paedagog', $result['patient_categories'][3]['type_key']);
    }

    /** @test */
    public function get_today_therapy_schedule_returns_grouped_resource()
    {
        $rawData = collect([
            (object)[
                'assessment_id' => 10,
                'child_name' => 'Rina',
                'type' => 'fisio',
                'scheduled_date' => '2026-01-05 08:00:00',
                'schedule_date' => '2026-01-05',
                'waktu' => '08:00',
            ],
            (object)[
                'assessment_id' => 10,
                'child_name' => 'Rina',
                'type' => 'wicara',
                'scheduled_date' => '2026-01-05 10:00:00',
                'schedule_date' => '2026-01-05',
                'waktu' => '10:00',
            ],
            (object)[
                'assessment_id' => 11,
                'child_name' => 'Dika',
                'type' => 'okupasi',
                'scheduled_date' => '2026-01-05 14:30:00',
                'schedule_date' => '2026-01-05',
                'waktu' => '14:30',
            ],
        ]);

        DB::shouldReceive('table')->andReturnSelf();
        DB::shouldReceive('join')->andReturnSelf();
        DB::shouldReceive('leftJoin')->andReturnSelf();
        DB::shouldReceive('select')->andReturnSelf();
        DB::shouldReceive('where')->andReturnSelf();
        DB::shouldReceive('whereDate')->andReturnSelf();
        DB::shouldReceive('orderBy')->andReturnSelf();
        DB::shouldReceive('raw')->andReturn('raw_expression');
        DB::shouldReceive('get')->once()->andReturn($rawData);

        $resource = $this->service->getTodayTherapySchedule('2026-01-05');

        $this->assertInstanceOf(TodayAssessmentScheduleResource::class, $resource);
        $this->assertInstanceOf(Collection::class, $resource->collection);
        $this->assertCount(2, $resource->collection);

        $firstGroup = $resource->collection->first();
        $this->assertCount(2, $firstGroup);
        $this->assertEquals('Rina', $firstGroup->first()->child_name);
    }

    /** @test */
    public function get_today_therapy_schedule_returns_empty_when_no_data()
    {
        DB::shouldReceive('table')->andReturnSelf();
        DB::shouldReceive('join')->andReturnSelf();
        DB::shouldReceive('leftJoin')->andReturnSelf();
        DB::shouldReceive('select')->andReturnSelf();
        DB::shouldReceive('where')->andReturnSelf();
        DB::shouldReceive('whereDate')->andReturnSelf();
        DB::shouldReceive('orderBy')->andReturnSelf();
        DB::shouldReceive('raw')->andReturn('raw_expression');
        DB::shouldReceive('get')->once()->andReturn(collect());

        $resource = $this->service->getTodayTherapySchedule('2026-01-05');

        $this->assertInstanceOf(TodayAssessmentScheduleResource::class, $resource);
        $this->assertCount(0, $resource->collection);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }
}
