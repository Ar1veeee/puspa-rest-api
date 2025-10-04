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
        $cacheKey = 'observations_pending';

        return Cache::remember(
            $cacheKey,
            self::CACHE_TTL_PENDING,
            fn() => $this->observationRepository->getByPendingStatus()
        );
    }

    public function getObservationsScheduled()
    {
        $cacheKey = "observations_scheduled";

        $result = Cache::remember(
            $cacheKey,
            self::CACHE_TTL_SCHEDULED,
            fn() => $this->observationRepository->getByScheduledStatus()
        );

        return $result;
    }

    public function getObservationsCompleted()
    {
        return $this->observationRepository->getByCompletedStatus();
    }

    public function getObservationScheduledDetail(int $id)
    {
        $detailScheduled = $this->observationRepository->getByScheduledDetail($id);

        if (!$detailScheduled) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        return $detailScheduled;
    }

    public function getObservationCompletedDetail(int $id)
    {
        $detaiCompleted = $this->observationRepository->getByCompletedDetail($id);

        if (!$detaiCompleted) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        return $detaiCompleted;
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
        $observation = $this->observationRepository->getById($id);
        if (!$observation) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        $ageCategory = $observation->age_category;
        $cacheKey = "observation_questions_{$ageCategory}";


        $result = Cache::rememberForever(
            $cacheKey,
            function () use ($ageCategory) {
                return $this->observationQuestionRepository->getByAgeCategory($ageCategory);
            }
        );

        return $result;
    }

    public function updateObservationDate(array $data, int $id)
    {
        $observation = $this->observationRepository->getById($id);
        if (!$observation) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }

        $updateData = [];

        if (isset($data['scheduled_date']) && !empty($data['scheduled_date'])) {
            $updateData['scheduled_date'] = $data['scheduled_date'];

            if ($observation->status === 'pending') {
                $updateData['status'] = 'scheduled';
            }
        }

        if (!empty($updateData)) {
            $this->observationRepository->update($id, $updateData);
            $this->clearObservationCaches();
        }

        $this->clearObservationCaches();
    }

    public function submitObservation(array $data, int $id)
    {
        $observation = $this->observationRepository->getById($id);
        if (!$observation) {
            throw new ModelNotFoundException('Observasi tidak ditemukan.');
        }
        if ($observation->status === 'completed') {
            throw new Exception('Observasi ini sudah diselesaikan dan tidak bisa diubah.');
        }

        $loggedInUser = Auth::user();

        $therapist = $loggedInUser->therapist;
        if (!$therapist) {
            throw new Exception('Profil terapis tidak ditemukan untuk pengguna ini.');
        }

        $questionIds = array_column($data['answers'], 'question_id');
        $questions = $this->observationQuestionRepository->getQuestionsByIds($questionIds)->keyBy('id');

        DB::transaction(function () use ($data, $id, $therapist, $questions, $observation) {
            $totalScore = 0;
            $answerToInsert = [];

            foreach ($data['answers'] as $answerData) {
                $question = $questions->get($answerData['question_id']);

                $scoreEarned = ($question && $answerData['answer'] === true) ? $question->score : 0;
                $totalScore += $scoreEarned;

                $answerToInsert[] = [
                    'observation_id' => $id,
                    'question_id' => $answerData['question_id'],
                    'answer' => $answerData['answer'],
                    'score_earned' => $scoreEarned,
                    'note' => $answerData['note'],
                ];
            }

            if (!empty($answerToInsert)) {
                $this->observationAnswerRepository->createMany($answerToInsert);
            }

            $observationUpdateData = [
                'therapist_id' => $therapist->id,
                'total_score' => $totalScore,
                'conclusion' => $data['conclusion'],
                'recommendation' => $data['recommendation'],
                'status' => 'completed',
            ];

            $observation->update($observationUpdateData);

            $assessmentData = [
                'child_id' => $observation->child_id,
                'therapist_id' => null,
                'fisio' => $data['fisio'],
                'wicara' => $data['wicara'],
                'paedagog' => $data['paedagog'],
                'okupasi' => $data['okupasi'],
            ];

            $this->assessmentRepository->create($assessmentData);
        });

        $this->clearObservationCaches();
    }
}
