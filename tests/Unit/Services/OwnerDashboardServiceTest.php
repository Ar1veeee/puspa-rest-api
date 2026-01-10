<?php

namespace Tests\Unit\Services;

use App\Services\OwnerDashboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OwnerDashboardServiceTest extends TestCase
{
    private OwnerDashboardService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OwnerDashboardService();

        Carbon::setTestNow('2026-01-15 10:00:00');
        app()->setLocale('id');
    }

    /** @test */
    public function get_dashboard_data_returns_correct_structure_and_calculations()
    {
        $this->mockCommonQueryMethods();

        DB::shouldReceive('count')
            ->times(4)
            ->andReturn(120, 100, 85, 70);

        $currentCompletion = (object)['total' => 80, 'completed' => 64];
        $previousCompletion = (object)['total' => 70, 'completed' => 49];
        DB::shouldReceive('first')
            ->twice()
            ->andReturn($currentCompletion, $previousCompletion);

        DB::shouldReceive('count')
            ->twice()
            ->andReturn(15, 25);

        DB::shouldReceive('pluck')
            ->times(4)
            ->andReturn(
                collect(['2025-10' => 90, '2025-11' => 95, '2025-12' => 100, '2026-01' => 120]),
                collect(['2025-10' => 60, '2025-11' => 65, '2025-12' => 70,  '2026-01' => 85]),
                collect(['2025-10' => 55, '2025-11' => 60, '2025-12' => 49,  '2026-01' => 64]),
                collect(['2025-10' => 8,  '2025-11' => 9,  '2025-12' => 10,  '2026-01' => 12])
            );

        $categoriesRaw = collect([
            (object)['type' => 'fisio',    'count' => 40],
            (object)['type' => 'wicara',  'count' => 25],
            (object)['type' => 'okupasi', 'count' => 15],
            (object)['type' => 'paedagog','count' => 5],
        ]);
        DB::shouldReceive('get')->once()->andReturn($categoriesRaw);

        $result = $this->service->getDashboardData(1, 2026);

        $this->assertEquals('Januari', $result['period']['month_name']);
        $this->assertEquals(120, $result['metrics']['total_observations']['current']);
        $this->assertEquals(20.0, $result['metrics']['total_observations']['change_percent']);
        $this->assertEquals(80.00, $result['metrics']['completion_rate']['current']);
        $this->assertEquals(14.29, $result['metrics']['completion_rate']['change_percent']);
        $this->assertEquals(15, $result['metrics']['unanswered_questions']['current']);
        $this->assertCount(4, $result['patient_categories']);
        $this->assertEquals(47.1, $result['patient_categories'][0]['percentage']);
    }

    /** @test */
    public function get_dashboard_data_handles_zero_division_gracefully()
    {
        $this->mockCommonQueryMethods();

        DB::shouldReceive('count')->andReturn(0);

        DB::shouldReceive('first')
            ->andReturn((object)['total' => 0, 'completed' => 0]);

        DB::shouldReceive('pluck')->andReturn(collect());

        DB::shouldReceive('get')->andReturn(collect());

        $result = $this->service->getDashboardData(1, 2026);

        $this->assertEquals(0, $result['metrics']['total_observations']['current']);
        $this->assertEquals(0, $result['metrics']['total_assessments']['current']);
        $this->assertEquals(0.00, $result['metrics']['completion_rate']['current']);
        $this->assertEquals(0, $result['metrics']['unanswered_questions']['current']);

        $this->assertEquals(0, $result['metrics']['total_observations']['change_percent']);
        $this->assertEquals('stable', $result['metrics']['total_observations']['trend']);
        $this->assertEquals('stable', $result['metrics']['completion_rate']['trend']);

        $this->assertEmpty($result['patient_categories']);

        $this->assertCount(4, $result['historical_trend']);
        $this->assertEquals(0, $result['historical_trend'][0]['data'][0]['value']);
    }

    /**
     * Helper untuk mock semua method query builder umum
     */
    private function mockCommonQueryMethods(): void
    {
        DB::shouldReceive('table')->andReturnSelf();
        DB::shouldReceive('join')->andReturnSelf();
        DB::shouldReceive('whereYear')->andReturnSelf();
        DB::shouldReceive('whereMonth')->andReturnSelf();
        DB::shouldReceive('whereBetween')->andReturnSelf();
        DB::shouldReceive('where')->andReturnSelf();
        DB::shouldReceive('whereNull')->andReturnSelf();
        DB::shouldReceive('whereNotNull')->andReturnSelf();
        DB::shouldReceive('groupBy')->andReturnSelf();
        DB::shouldReceive('orderBy')->andReturnSelf();
        DB::shouldReceive('select')->andReturnSelf();
        DB::shouldReceive('selectRaw')->andReturnSelf();
        DB::shouldReceive('raw')->andReturn('raw_expression');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }
}
