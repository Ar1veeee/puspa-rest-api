<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentDetailRepository;
use App\Http\Repositories\ObservationRepository;
use App\Http\Repositories\ObservationQuestionRepository;
use App\Http\Repositories\ObservationAnswerRepository;
use App\Models\Assessment;
use App\Models\Observation;
use App\Models\User;
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

    public const CACHE_TTL_PENDING = 600;
    public const CACHE_TTL_SCHEDULED = 600;

    public function __construct(
        ObservationRepository         $observationRepository,
        ObservationQuestionRepository $observationQuestionRepository,
        ObservationAnswerRepository   $observationAnswerRepository,
        AssessmentDetailRepository $assessmentRepository
    ) {
        $this->observationRepository = $observationRepository;
        $this->observationQuestionRepository = $observationQuestionRepository;
        $this->observationAnswerRepository = $observationAnswerRepository;
        $this->assessmentRepository = $assessmentRepository;
    }

    public function getObservations(array $filters = [])
    {
        $status     = $filters['status'];
        $direction  = ($status === 'completed') ? 'desc' : 'asc';
        $cacheKey   = "observations_{$status}_{$direction}";

        $ttl = ($status === 'pending') ? self::CACHE_TTL_PENDING : self::CACHE_TTL_SCHEDULED;

        if (in_array($status, ['pending', 'scheduled'])) {
            return Cache::remember($cacheKey, $ttl, function () use ($filters, $direction) {
                return $this->observationRepository->getByFilters($filters, $direction);
            });
        }

        return $this->observationRepository->getByFilters($filters, 'desc');
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
        $admin = $this->getAuthenticatedAdmin();

        $this->prepareObservationDateUpdate($data, $observation, $admin);

        $this->clearObservationCaches();
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

            $admin = $this->getAuthenticatedAdmin();

            if (!empty($data['scheduled_date']) && !empty($data['scheduled_time'])) {
                $newDateTime = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $data['scheduled_date'] . ' ' . $data['scheduled_time']
                );

                $this->assessmentRepository->setScheduledDate($observation->id, $newDateTime, $admin);
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
        /** @var User $user */
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

    private function getAuthenticatedAdmin()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            throw new Exception('Tidak ada pengguna yang terautentikasi.');
        }

        $admin = $user->admin;

        if (!$admin) {
            throw new Exception('Profil admin tidak ditemukan untuk pengguna ini.');
        }

        return $admin;
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
        $assessment = Assessment::create([
            'observation_id' => $observation->id,
            'child_id' => $observation->child_id,
        ]);

        $assessmentTypes = [];

        $assessmentTypes[] = 'umum';
        if ($data['fisio'] ?? false) {
            $assessmentTypes[] = 'fisio';
        }
        if ($data['okupasi'] ?? false) {
            $assessmentTypes[] = 'okupasi';
        }
        if ($data['wicara'] ?? false) {
            $assessmentTypes[] = 'wicara';
        }
        if ($data['paedagog'] ?? false) {
            $assessmentTypes[] = 'paedagog';
        }

        foreach ($assessmentTypes as $type) {
            $this->assessmentRepository->create([
                'assessment_id' => $assessment->id,
                'type' => $type,
                'admin_id' => null,
                'therapist_id' => null,
                'status' => 'pending',
                'scheduled_date' => null,
                'completed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function prepareObservationDateUpdate(array $data, $observation, $admin)
    {

        if (!empty($data['scheduled_date']) && !empty($data['scheduled_time'])) {
            $newDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $data['scheduled_date'] . ' ' . $data['scheduled_time']
            );

            if ($newDateTime && !$newDateTime->equalTo($observation->scheduled_date)) {
                $observation->update([
                    'admin_id' => $admin->id,
                    'scheduled_date' => $newDateTime,
                    'status' => 'scheduled',
                ]);
            }
        }
    }

    private function getCacheKey(string $baseKey): string
    {
        return $baseKey;
    }
}
