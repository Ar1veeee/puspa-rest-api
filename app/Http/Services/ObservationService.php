<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Repositories\ObservationQuestionRepository;
use App\Http\Repositories\ObservationAnswerRepository;
use App\Models\Observation;
use App\Traits\ClearsCaches;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

    public function getObservations(array $filters = [])
    {
        $status = $filters['status'] ?? null;

        if ($status === 'pending' || $status === 'scheduled') {
            $cacheKey = "observations_{$status}";
            $ttl = ($status === 'pending') ? self::CACHE_TTL_PENDING : self::CACHE_TTL_SCHEDULED;

            return Cache::remember($cacheKey, $ttl, function () use ($status) {
                return $this->observationRepository->getByFilters(['status' => $status]);
            });
        }

        return $this->observationRepository->getByFilters($filters);
    }

    public function getObservationQuestions(Observation $observation)
    {
        $ageCategory = $observation->age_category;
        $cacheKey = "observation_questions_{$ageCategory}";

        return Cache::rememberForever(
            $cacheKey,
            fn() => $this->observationQuestionRepository->getByAgeCategory($ageCategory)
        );
    }

    public function updateObservationDate(array $data, Observation $observation)
    {
        $updateData = $this->prepareObservationDateUpdate($data, $observation);

        if (empty($updateData)) {
            return $observation;
        }

        $updated = $this->observationRepository->update($observation->id, $updateData);
        $this->clearObservationCaches();

        return $updated;
    }

    public function submitObservation(array $data, Observation $observation)
    {
        $this->validateObservationForSubmission($observation);

        $this->validateAgeCategory($observation, $data['answers']);

        $therapist = $this->getAuthenticatedTherapist();

        $questions = $this->getQuestionsForAnswers($data['answers']);

        DB::beginTransaction();
        try {
            $totalScore = $this->saveObservationAnswers($data['answers'], $observation->id, $questions);

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

    public function assessmentAgreement(array $data, Observation $observation)
    {
        DB::beginTransaction();
        try {
            $updateObservation = [];

            if (!empty($data['scheduled_date'])) {
                $this->assessmentRepository->setScheduledDate($observation->id, $data['scheduled_date']);
            }

            $updateObservation['is_continued_to_assessment'] = true;

            $updated = $this->observationRepository->update($observation->id, $updateObservation);

            DB::commit();
            $this->clearObservationCaches();

            return $updated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // ========== Private Helper Methods ==========

    private function validateObservationForSubmission($observation): void
    {
        if ($observation->status === 'completed') {
            throw new Exception('Observasi ini sudah diselesaikan dan tidak bisa diubah.');
        }
    }

    private function getAuthenticatedTherapist()
    {
        $user = Auth::user();

        if (!$user) {
            throw new Exception('Tidak ada pengguna yang terautentikasi.');
        }

        $therapist = $user->therapist;

        if (!$therapist) {
            throw new Exception('Profil terapis tidak ditemukan untuk pengguna ini.');
        }

        return $therapist;
    }

    private function getQuestionsForAnswers(array $answers)
    {
        $questionIds = array_column($answers, 'question_id');
        $questions = $this->observationQuestionRepository
            ->getQuestionsByIds($questionIds)
            ->keyBy('id');

        foreach ($questionIds as $id) {
            if (!$questions->has($id)) {
                throw new Exception("Pertanyaan dengan ID {$id} tidak ditemukan.");
            }
        }

        return $questions;
    }

    private function validateAgeCategory(Observation $observation, array $answers)
    {
        $observationAgeCategory = $observation->age_category;
        $question_ids = array_column($answers, 'question_id');

        if (empty($question_ids)) {
            return; // tidak ada jawaban, skip validasi
        }

        $questions = $this->observationQuestionRepository
            ->getQuestionsByIds($question_ids)
            ->pluck('age_category', 'id');

        foreach ($answers as $answer) {
            $question_id = $answer['question_id'] ?? null;
            $questionAgeCategory = $questions[$question_id] ?? null;

            if (!$question_id || !$questionAgeCategory) {
                throw new Exception("Pertanyaan dengan ID {$question_id} tidak ditemukan.");
            }

            if ($questionAgeCategory !== $observationAgeCategory) {
                throw new Exception(
                    "Pertanyaan ID {$question_id} untuk kategori usia '{$questionAgeCategory}' " .
                    "tidak sesuai dengan observasi kategori usia '{$observationAgeCategory}'."
                );
            }
        }
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
            'completed_at' => Carbon::now(),
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

        if (!empty($data['scheduled_date']) && !empty($data['scheduled_time'])) {
            $newDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $data['scheduled_date'] . ' ' . $data['scheduled_time']
            );

            if ($newDateTime && !$newDateTime->equalTo($observation->scheduled_date)) {
                $updateData['scheduled_date'] = $newDateTime;
            }

            if ($observation->status === 'pending') {
                $updateData['status'] = 'scheduled';
            }
        }

        return $updateData;
    }

    private function getCacheKey(string $baseKey): string
    {
        return $baseKey;
    }
}
