<?php

namespace Tests\Unit\Services;

use App\Http\Repositories\ObservationAnswerRepository;
use App\Http\Repositories\ObservationQuestionRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Services\ObservationService;
use App\Models\Observation;
use App\Models\ObservationAnswer;
use App\Models\ObservationQuestion;
use App\Models\Therapist;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ObservationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ObservationService $observationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->observationService = new ObservationService(
            new ObservationRepository(new Observation()),
            new ObservationQuestionRepository(new ObservationQuestion()),
            new ObservationAnswerRepository(new ObservationAnswer())
        );
    }

    /**
     * @test
     * Testing observation questions should return questions based on category.
     */
    public function getObservationQuestionsShouldReturnQuestionsBasedOnCategory(): void
    {
        $observation = Observation::factory()->create(['age_category' => 'anak-anak']);
        ObservationQuestion::factory()->count(5)->create(['age_category' => 'anak-anak']);
        ObservationQuestion::factory()->count(3)->create(['age_category' => 'balita']);

        $questions = $this->observationService->getObservationQuestions($observation->id);

        $this->assertCount(5, $questions);
        $this->assertEquals('anak-anak', $questions->first()->age_category);
    }

    /**
     * @test
     * Testing update observation date and status should succeed with valid data.
     */
    public function updateObservationDateShouldUpdateDateAndStatus(): void
    {
        $observation = Observation::factory()->create(['status' => 'pending']);
        $newDate = now()->addDays(10)->format('Y-m-d');

        $this->observationService->updateObservationDate(['scheduled_date' => $newDate], $observation->id);

        $observation->refresh();
        $this->assertEquals($newDate, $observation->scheduled_date->format('Y-m-d'));
        $this->assertEquals('scheduled', $observation->status);
    }

    /**
     * @test
     * Testing update observation date should throw exception if observation not found.
     */
    public function updateObservationDateShouldThrowExceptionIfNotFound(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->observationService->updateObservationDate(['scheduled_date' => now()], 999);
    }

    /**
     * @test
     * Testing submit observation should succeed with valid data.
     */
    public function submitObservationShouldSucceedWithValidData(): void
    {
        $therapistUser = User::factory()->create(['role' => 'terapis']);
        $therapist = Therapist::factory()->create(['user_id' => $therapistUser->id]);
        $observation = Observation::factory()->create(['status' => 'scheduled']);

        $question1 = ObservationQuestion::factory()->create(['score' => 3]);
        $question2 = ObservationQuestion::factory()->create(['score' => 2]);
        $question3 = ObservationQuestion::factory()->create(['score' => 1]);

        $submissionData = [
            'answers' => [
                ['question_id' => $question1->id, 'answer' => true, 'note' => 'Note 1'],
                ['question_id' => $question2->id, 'answer' => false, 'note' => ''],
                ['question_id' => $question3->id, 'answer' => true, 'note' => 'Note 3'],
            ],
            'conclusion' => 'Kesimpulan Tes.',
            'recommendation' => 'Rekomendasi Tes.',
        ];


        $this->actingAs($therapistUser);

        $this->observationService->submitObservation($submissionData, $observation->id);


        $observation->refresh();
        $this->assertEquals($therapist->id, $observation->therapist_id);
        $this->assertEquals(4, $observation->total_score);
        $this->assertEquals('Kesimpulan Tes.', $observation->conclusion);
        $this->assertEquals('completed', $observation->status);
        $this->assertDatabaseCount('observation_answers', 3);
    }

    /**
     * @test
     * Testing submit observation should throw exception if observation not found.
     */
    public function submitObservationShouldThrowExceptionIfAlreadyCompleted(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Observasi ini sudah diselesaikan dan tidak bisa diubah.');

        $therapistUser = User::factory()->create(['role' => 'terapis']);
        Therapist::factory()->create(['user_id' => $therapistUser->id]);
        $observation = Observation::factory()->create(['status' => 'completed']);

        $this->actingAs($therapistUser);
        $this->observationService->submitObservation(
            [
                'answers' => [],
                'conclusion' => '',
                'recommendation' => ''
            ],
            $observation->id
        );
    }
}
