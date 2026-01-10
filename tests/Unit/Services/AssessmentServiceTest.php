<?php

namespace Tests\Unit\Services;

use App\Actions\Assessment\StoreAssessorAssessmentAction;
use App\Actions\Assessment\StoreParentAssessmentAction;
use App\Actions\Assessment\UpdateScheduledDateAction;
use App\Models\Assessment;
use App\Services\AssessmentService;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class AssessmentServiceTest extends TestCase
{
    private StoreParentAssessmentAction|MockInterface $storeParentAssessmentAction;
    private StoreAssessorAssessmentAction|MockInterface $storeAssessorAssessmentAction;
    private UpdateScheduledDateAction|MockInterface $updateScheduledDateAction;
    private AssessmentService $assessmentService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->storeParentAssessmentAction = Mockery::mock(StoreParentAssessmentAction::class);
        $this->storeAssessorAssessmentAction = Mockery::mock(StoreAssessorAssessmentAction::class);
        $this->updateScheduledDateAction = Mockery::mock(UpdateScheduledDateAction::class);

        $this->assessmentService = new AssessmentService(
            $this->storeParentAssessmentAction,
            $this->storeAssessorAssessmentAction,
            $this->updateScheduledDateAction
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_delegates_store_parent_assessment_to_action()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'interview_parent';
        $data = [
            'answers' => [
                ['question_id' => 1, 'answer' => 'Yes'],
                ['question_id' => 2, 'answer' => 'No'],
            ],
        ];

        // Setup mock BEFORE Cache::shouldReceive
        $assessment->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(1);

        Cache::shouldReceive('forget')
            ->once()
            ->with("answers_1_{$type}")
            ->andReturn(true);

        $this->storeParentAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->with($assessment, $type, $data)
            ->andReturnNull();

        // Act
        $this->assessmentService->storeParentAssessment($assessment, $type, $data);

        // Assert - Mockery verifies expectations
        $this->assertTrue(true);
    }

    /** @test */
    public function store_parent_assessment_clears_cache()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'chat_parent';
        $data = ['answers' => []];

        $assessment->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(5);

        Cache::shouldReceive('forget')
            ->once()
            ->with('answers_5_chat_parent')
            ->andReturn(true);

        $this->storeParentAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->assessmentService->storeParentAssessment($assessment, $type, $data);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function it_delegates_store_assessor_assessment_to_action()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'interview_assessor';
        $data = [
            'answers' => [
                ['question_id' => 10, 'answer' => 'Good'],
                ['question_id' => 11, 'answer' => 'Excellent'],
            ],
        ];

        $assessment->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(2);

        Cache::shouldReceive('forget')
            ->once()
            ->with("answers_{$assessment->id}_{$type}")
            ->andReturn(true);

        $this->storeAssessorAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->with($assessment, $type, $data)
            ->andReturnNull();

        // Act
        $this->assessmentService->storeAssessorAssessment($assessment, $type, $data);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function store_assessor_assessment_clears_cache()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'observation_assessor';
        $data = ['answers' => []];

        $assessment->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(10);

        Cache::shouldReceive('forget')
            ->once()
            ->with('answers_10_observation_assessor')
            ->andReturn(true);

        $this->storeAssessorAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->assessmentService->storeAssessorAssessment($assessment, $type, $data);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function it_delegates_update_scheduled_date_to_action()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $data = [
            'scheduled_dates' => [
                ['detail_id' => 1, 'scheduled_date' => '2024-01-15'],
                ['detail_id' => 2, 'scheduled_date' => '2024-01-20'],
            ],
        ];

        $this->updateScheduledDateAction
            ->shouldReceive('execute')
            ->once()
            ->with($assessment, $data)
            ->andReturnNull();

        // Act
        $this->assessmentService->updateScheduledDate($assessment, $data);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function it_passes_correct_parameters_to_store_parent_action()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'interview_parent';
        $data = ['answers' => [['question_id' => 1, 'answer' => 'Test']]];

        $assessment->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(3);

        Cache::shouldReceive('forget')->andReturn(true);

        $this->storeParentAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($a, $t, $d) use ($assessment, $type, $data) {
                return $a === $assessment && $t === $type && $d === $data;
            })
            ->andReturnNull();

        // Act
        $this->assessmentService->storeParentAssessment($assessment, $type, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function it_passes_correct_parameters_to_store_assessor_action()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'chat_assessor';
        $data = ['answers' => [['question_id' => 5, 'answer' => 'Response']]];

        $assessment->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(7);

        Cache::shouldReceive('forget')->andReturn(true);

        $this->storeAssessorAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($a, $t, $d) use ($assessment, $type, $data) {
                return $a === $assessment && $t === $type && $d === $data;
            })
            ->andReturnNull();

        // Act
        $this->assessmentService->storeAssessorAssessment($assessment, $type, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function it_passes_correct_parameters_to_update_scheduled_date_action()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $data = [
            'scheduled_dates' => [
                ['detail_id' => 1, 'scheduled_date' => '2024-02-01'],
            ],
        ];

        $this->updateScheduledDateAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($a, $d) use ($assessment, $data) {
                return $a === $assessment && $d === $data;
            })
            ->andReturnNull();

        // Act
        $this->assessmentService->updateScheduledDate($assessment, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function store_parent_assessment_invokes_action_exactly_once()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'test_parent';
        $data = ['answers' => []];

        $assessment->shouldReceive('getAttribute')->andReturn(1);
        Cache::shouldReceive('forget')->andReturn(true);

        $this->storeParentAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->assessmentService->storeParentAssessment($assessment, $type, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function store_assessor_assessment_invokes_action_exactly_once()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'test_assessor';
        $data = ['answers' => []];

        $assessment->shouldReceive('getAttribute')->andReturn(1);
        Cache::shouldReceive('forget')->andReturn(true);

        $this->storeAssessorAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->assessmentService->storeAssessorAssessment($assessment, $type, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function update_scheduled_date_invokes_action_exactly_once()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $data = ['scheduled_dates' => []];

        $this->updateScheduledDateAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->assessmentService->updateScheduledDate($assessment, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function it_handles_different_assessment_types_for_parent()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $types = ['interview_parent', 'chat_parent', 'observation_parent'];

        foreach ($types as $type) {
            $data = ['answers' => []];

            $assessment->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn(rand(1, 100));

            Cache::shouldReceive('forget')
                ->once()
                ->andReturn(true);

            $this->storeParentAssessmentAction
                ->shouldReceive('execute')
                ->once()
                ->with($assessment, $type, $data)
                ->andReturnNull();

            // Act
            $this->assessmentService->storeParentAssessment($assessment, $type, $data);
        }

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function it_handles_different_assessment_types_for_assessor()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $types = ['interview_assessor', 'chat_assessor', 'observation_assessor'];

        foreach ($types as $type) {
            $data = ['answers' => []];

            $assessment->shouldReceive('getAttribute')
                ->with('id')
                ->andReturn(rand(1, 100));

            Cache::shouldReceive('forget')
                ->once()
                ->andReturn(true);

            $this->storeAssessorAssessmentAction
                ->shouldReceive('execute')
                ->once()
                ->with($assessment, $type, $data)
                ->andReturnNull();

            // Act
            $this->assessmentService->storeAssessorAssessment($assessment, $type, $data);
        }

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function store_parent_assessment_returns_void()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'test_parent';
        $data = ['answers' => []];

        $assessment->shouldReceive('getAttribute')->andReturn(1);
        Cache::shouldReceive('forget')->andReturn(true);
        $this->storeParentAssessmentAction->shouldReceive('execute')->andReturnNull();

        // Act
        $result = $this->assessmentService->storeParentAssessment($assessment, $type, $data);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function store_assessor_assessment_returns_void()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $type = 'test_assessor';
        $data = ['answers' => []];

        $assessment->shouldReceive('getAttribute')->andReturn(1);
        Cache::shouldReceive('forget')->andReturn(true);
        $this->storeAssessorAssessmentAction->shouldReceive('execute')->andReturnNull();

        // Act
        $result = $this->assessmentService->storeAssessorAssessment($assessment, $type, $data);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function update_scheduled_date_returns_void()
    {
        // Arrange
        $assessment = Mockery::mock(Assessment::class);
        $data = ['scheduled_dates' => []];

        $this->updateScheduledDateAction->shouldReceive('execute')->andReturnNull();

        // Act
        $result = $this->assessmentService->updateScheduledDate($assessment, $data);

        // Assert
        $this->assertNull($result);
    }
}
