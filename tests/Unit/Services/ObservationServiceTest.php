<?php

namespace Tests\Unit\Services;

use App\Actions\Observation\AgreeToAssessmentAction;
use App\Actions\Observation\RescheduleObservationAction;
use App\Actions\Observation\SubmitObservationAction;
use App\Models\Observation;
use App\Services\ObservationService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ObservationServiceTest extends TestCase
{
    private SubmitObservationAction|MockInterface $submitObservationAction;
    private RescheduleObservationAction|MockInterface $rescheduleObservationAction;
    private AgreeToAssessmentAction|MockInterface $agreeToAssessmentAction;
    private ObservationService $observationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->submitObservationAction = Mockery::mock(SubmitObservationAction::class);
        $this->rescheduleObservationAction = Mockery::mock(RescheduleObservationAction::class);
        $this->agreeToAssessmentAction = Mockery::mock(AgreeToAssessmentAction::class);

        $this->observationService = new ObservationService(
            $this->submitObservationAction,
            $this->rescheduleObservationAction,
            $this->agreeToAssessmentAction
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_delegates_submit_to_submit_observation_action()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = [
            'answers' => [
                ['question_id' => 1, 'answer' => 'Yes', 'note' => 'Good'],
                ['question_id' => 2, 'answer' => 'No', 'note' => 'Needs improvement'],
            ],
        ];

        $submittedObservation = Mockery::mock(Observation::class);

        $this->submitObservationAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturn($submittedObservation);

        // Act
        $result = $this->observationService->submit($observation, $data);

        // Assert
        $this->assertSame($submittedObservation, $result);
    }

    /** @test */
    public function submit_returns_observation_instance()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['answers' => []];

        $submittedObservation = Mockery::mock(Observation::class);

        $this->submitObservationAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturn($submittedObservation);

        // Act
        $result = $this->observationService->submit($observation, $data);

        // Assert
        $this->assertInstanceOf(Observation::class, $result);
    }

    /** @test */
    public function it_delegates_reschedule_to_reschedule_observation_action()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = [
            'scheduled_date' => '2024-03-15 10:00:00',
            'reason' => 'Family emergency',
        ];

        $this->rescheduleObservationAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturnNull();

        // Act
        $this->observationService->reschedule($observation, $data);

        // Assert - Mockery verifies expectations
        $this->assertTrue(true);
    }

    /** @test */
    public function reschedule_returns_void()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['scheduled_date' => '2024-04-01'];

        $this->rescheduleObservationAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $result = $this->observationService->reschedule($observation, $data);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function it_delegates_agree_to_assessment_to_action()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = [
            'agreed' => true,
            'assessment_types' => ['interview', 'chat', 'observation'],
        ];

        $this->agreeToAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturnNull();

        // Act
        $this->observationService->agreeToAssessment($observation, $data);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function agree_to_assessment_returns_void()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['agreed' => true];

        $this->agreeToAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $result = $this->observationService->agreeToAssessment($observation, $data);

        // Assert
        $this->assertNull($result);
    }

    /** @test */
    public function it_passes_correct_parameters_to_submit_action()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['answers' => [['question_id' => 5, 'answer' => 'Test']]];

        $submittedObservation = Mockery::mock(Observation::class);

        $this->submitObservationAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($obs, $d) use ($observation, $data) {
                return $obs === $observation && $d === $data;
            })
            ->andReturn($submittedObservation);

        // Act
        $result = $this->observationService->submit($observation, $data);

        // Assert
        $this->assertInstanceOf(Observation::class, $result);
    }

    /** @test */
    public function it_passes_correct_parameters_to_reschedule_action()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['scheduled_date' => '2024-05-20', 'reason' => 'Conflict'];

        $this->rescheduleObservationAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($obs, $d) use ($observation, $data) {
                return $obs === $observation && $d === $data;
            })
            ->andReturnNull();

        // Act
        $this->observationService->reschedule($observation, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function it_passes_correct_parameters_to_agree_to_assessment_action()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['agreed' => false, 'reason' => 'Not ready'];

        $this->agreeToAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->withArgs(function ($obs, $d) use ($observation, $data) {
                return $obs === $observation && $d === $data;
            })
            ->andReturnNull();

        // Act
        $this->observationService->agreeToAssessment($observation, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function submit_invokes_action_exactly_once()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['answers' => []];
        $submittedObservation = Mockery::mock(Observation::class);

        $this->submitObservationAction
            ->shouldReceive('execute')
            ->once()
            ->andReturn($submittedObservation);

        // Act
        $this->observationService->submit($observation, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function reschedule_invokes_action_exactly_once()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['scheduled_date' => now()->addDays(7)->format('Y-m-d')];

        $this->rescheduleObservationAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->observationService->reschedule($observation, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function agree_to_assessment_invokes_action_exactly_once()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = ['agreed' => true];

        $this->agreeToAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        // Act
        $this->observationService->agreeToAssessment($observation, $data);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /** @test */
    public function it_handles_submit_with_multiple_answers()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = [
            'answers' => [
                ['question_id' => 1, 'answer' => 'Answer 1', 'note' => 'Note 1'],
                ['question_id' => 2, 'answer' => 'Answer 2', 'note' => 'Note 2'],
                ['question_id' => 3, 'answer' => 'Answer 3', 'note' => 'Note 3'],
            ],
        ];

        $submittedObservation = Mockery::mock(Observation::class);

        $this->submitObservationAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturn($submittedObservation);

        // Act
        $result = $this->observationService->submit($observation, $data);

        // Assert
        $this->assertInstanceOf(Observation::class, $result);
    }

    /** @test */
    public function it_handles_reschedule_with_reason()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = [
            'scheduled_date' => '2024-06-15 14:30:00',
            'reason' => 'Parent requested different time',
        ];

        $this->rescheduleObservationAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturnNull();

        // Act
        $this->observationService->reschedule($observation, $data);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function it_handles_agree_to_assessment_with_multiple_types()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = [
            'agreed' => true,
            'assessment_types' => ['interview', 'chat', 'observation'],
        ];

        $this->agreeToAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturnNull();

        // Act
        $this->observationService->agreeToAssessment($observation, $data);

        // Assert
        $this->assertTrue(true);
    }

    /** @test */
    public function it_handles_disagree_to_assessment()
    {
        // Arrange
        $observation = Mockery::mock(Observation::class);
        $data = [
            'agreed' => false,
            'reason' => 'Not ready for assessment yet',
        ];

        $this->agreeToAssessmentAction
            ->shouldReceive('execute')
            ->once()
            ->with($observation, $data)
            ->andReturnNull();

        // Act
        $this->observationService->agreeToAssessment($observation, $data);

        // Assert
        $this->assertTrue(true);
    }
}
