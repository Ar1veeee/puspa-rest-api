<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Repositories\ObservationQuestionRepository;
use App\Http\Repositories\ObservationAnswerRepository;
use App\Traits\ClearsCaches;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ObservationService
{
    use ClearsCaches;

    protected $observationRepository;
    protected $observationQuestionRepository;
    protected $observationAnswerRepository;
    protected $assessmentRepository;

    public const CACHE_TTL_QUESTIONS = null;
    public const CACHE_TTL_PENDING = 600;
    public const CACHE_TTL_SCHEDULED = 600;

    public function __construct(
        ObservationRepository         $observationRepository,
        ObservationQuestionRepository $observationQuestionRepository,
        ObservationAnswerRepository   $observationAnswerRepository,
        AssessmentRepository          $assessmentRepository
    )
    {
        $this->observationRepository = $observationRepository;
        $this->observationQuestionRepository = $observationQuestionRepository;
        $this->observationAnswerRepository = $observationAnswerRepository;
        $this->assessmentRepository = $assessmentRepository;
    }

    public function getObservationsPending()
    {
        $cacheKey = $this->getCacheKey('observations_pending');

        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL_PENDING,
            fn() => $this->observationRepository->getByPendingStatus()
        );
    }

    public function getObservationsScheduled()
    {
        $cacheKey = $this->getCacheKey('observations_scheduled');

        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL_SCHEDULED,
            fn() => $this->observationRepository->getByScheduledStatus()
        );
    }

    public function getObservationsCompleted()
    {
        return $this->observationRepository->getByCompletedStatus();
    }

    public function getObservationScheduledDetail(int $id)
    {
        $observation = $this->observationRepository->getByScheduledDetail($id);

        if (!$observation) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        return $observation;
    }

    public function getObservationCompletedDetail(int $id)
    {
        $observation = $this->observationRepository->getByCompletedDetail($id);

        if (!$observation) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        return $observation;
    }

    public function getObservationDetailAnswer(int $id)
    {
        $observationAnswer = $this->observationRepository->getDetailAnswer($id);

        if (!$observationAnswer) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        return $observationAnswer;
    }

    public function getObservationQuestions(int $id)
    {
        $observation = $this->findObservationOrFail($id);
        $ageCategory = $observation->age_category;
        $cacheKey = "observation_questions_{$ageCategory}";

        return Cache::rememberForever(
            $cacheKey,
            fn() => $this->observationQuestionRepository->getByAgeCategory($ageCategory)
        );
    }

    public function updateObservationDate(array $data, int $id)
    {
        $observation = $this->findObservationOrFail($id);

        $updateData = $this->prepareObservationDateUpdate($data, $observation);

        if (empty($updateData)) {
            return $observation;
        }

        $updated = $this->observationRepository->update($id, $updateData);
        $this->clearObservationCaches();

        return $updated;
    }

    public function submitObservation(array $data, int $id)
    {
        $observation = $this->findObservationOrFail($id);

        $this->validateObservationForSubmission($observation);

        $therapist = $this->getAuthenticatedTherapist();

        $questions = $this->getQuestionsForAnswers($data['answers']);

        DB::beginTransaction();
        try {
            $totalScore = $this->saveObservationAnswers($data['answers'], $id, $questions);

            $this->updateObservationAsCompleted($observation, $therapist, $totalScore, $data);

            $this->createAssessmentFromObservation($observation, $data);

            DB::commit();
            $this->clearObservationCaches();

            return $observation->fresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function assessmentAgreement(array $data, int $id)
    {
        $this->findObservationOrFail($id);

        DB::beginTransaction();
        try {
            $updateObservation = [];

            if (!empty($data['scheduled_date'])) {
                $this->assessmentRepository->setScheduledDate($id, $data['scheduled_date']);
            }

            $updateObservation['is_continued_to_assessment'] = true;

            $updated = $this->observationRepository->update($id, $updateObservation);

            DB::commit();
            $this->clearObservationCaches();

            return $updated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // ========== Private Helper Methods ==========

    private function findObservationOrFail(int $id)
    {
        $observation = $this->observationRepository->getById($id);

        if (!$observation) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        return $observation;
    }

    private function validateObservationForSubmission($observation): void
    {
        if ($observation->status === 'completed') {
            throw new Exception('Observasi ini sudah diselesaikan dan tidak bisa diubah.');
        }
    }

    private function getAuthenticatedTherapist()
    {
        $therapist = Auth::user()->therapist;

        if (!$therapist) {
            throw new Exception('Profil terapis tidak ditemukan untuk pengguna ini.');
        }

        return $therapist;
    }

    private function getQuestionsForAnswers(array $answers)
    {
        $questionIds = array_column($answers, 'question_id');
        return $this->observationQuestionRepository
            ->getQuestionsByIds($questionIds)
            ->keyBy('id');
    }

    private function saveObservationAnswers(array $answers, int $observationId, $questions): int
    {
        $totalScore = 0;
        $answersToInsert = [];

        foreach ($answers as $answerData) {
            $question = $questions->get($answerData['question_id']);
            $scoreEarned = ($question && $answerData['answer'] === true)
                ? $question->score
                : 0;

            $totalScore += $scoreEarned;

            $answersToInsert[] = [
                'observation_id' => $observationId,
                'question_id' => $answerData['question_id'],
                'answer' => $answerData['answer'],
                'score_earned' => $scoreEarned,
                'note' => $answerData['note'] ?? null,
            ];
        }

        if (!empty($answersToInsert)) {
            $this->observationAnswerRepository->createMany($answersToInsert);
        }

        return $totalScore;
    }

    private function updateObservationAsCompleted($observation, $therapist, int $totalScore, array $data): void
    {
        $observation->update([
            'therapist_id' => $therapist->id,
            'total_score' => $totalScore,
            'conclusion' => $data['conclusion'],
            'recommendation' => $data['recommendation'],
            'status' => 'completed',
        ]);
    }

    private function createAssessmentFromObservation($observation, array $data): void
    {
        $this->assessmentRepository->create([
            'observation_id' => $observation->id,
            'child_id' => $observation->child_id,
            'therapist_id' => null,
            'fisio' => $data['fisio'] ?? false,
            'wicara' => $data['wicara'] ?? false,
            'paedagog' => $data['paedagog'] ?? false,
            'okupasi' => $data['okupasi'] ?? false,
        ]);
    }

    private function prepareObservationDateUpdate(array $data, $observation): array
    {
        $updateData = [];

        if (!empty($data['scheduled_date'])) {
            $updateData['scheduled_date'] = $data['scheduled_date'];

            if ($observation->status === 'pending') {
                $updateData['status'] = 'scheduled';
            }
        }

        return $updateData;
    }

    private function getCacheKey(string $baseKey): string
    {
        $userId = Auth::id();
        return "{$baseKey}_{$userId}";
    }
}
