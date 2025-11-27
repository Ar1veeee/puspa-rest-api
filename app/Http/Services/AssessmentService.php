<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentDetailRepository;
use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\GuardianRepository;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\AssessmentQuestion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AssessmentService
{
    protected $assessmentRepository;
    protected $assessmentDetailRepository;
    protected $guardianRepository;

    public function __construct(
        AssessmentRepository       $assessmentRepository,
        AssessmentDetailRepository $assessmentDetailRepository,
        GuardianRepository         $guardianRepository,
    )
    {
        $this->assessmentRepository = $assessmentRepository;
        $this->assessmentDetailRepository = $assessmentDetailRepository;
        $this->guardianRepository = $guardianRepository;
    }

    public function getChildrenAssessment(string $userId)
    {
        return $this->guardianRepository->getAssessments($userId);
    }

    public function getParentsAssessment(array $filters = [])
    {
        $queryFilters = [];

        $queryFilters['parent_completed_status'] = $filters['status'];

        if (isset($filters['date'])) {
            $queryFilters['scheduled_date'] = $filters['date'];
        }

        if (isset($filters['search'])) {
            $queryFilters['search'] = $filters['search'];
        }

        return $this->assessmentDetailRepository->getParentsAssessmentWithFilter($queryFilters);
    }

    public function getAssessmentsByStatus(array $filters = [])
    {
        $queryFilters = [];

        $queryFilters['status'] = $filters['status'];

        if (isset($filters['date'])) {
            $queryFilters['scheduled_date'] = $filters['date'];
        }

        if (isset($filters['search'])) {
            $queryFilters['search'] = $filters['search'];
        }

        return $this->assessmentDetailRepository->getAssessmentByStatusWithFilter($queryFilters);
    }

    public function getAssessmentsByType(array $filters = [])
    {
        $queryFilters = [];

        $queryFilters['type'] = $filters['type'];

        if (isset($filters['date'])) {
            $queryFilters['scheduled_date'] = $filters['date'];
        }

        if (isset($filters['status'])) {
            $queryFilters['status'] = $filters['status'];
        }

        if (isset($filters['search'])) {
            $queryFilters['search'] = $filters['search'];
        }

        return $this->assessmentDetailRepository->getAssessmentByTypeWithFilter($queryFilters);
    }

    public function getQuestionsByType(string $type): array
    {
        $groups = $this->assessmentRepository->getQuestionByType($type);

        return [
            'assessment_type' => $type,
            'groups' => $groups->map(function ($group) {
                return [
                    'group_id' => $group->id,
                    'group_key' => $group->group_key,
                    'title' => $group->group_title,
                    'filled_by' => $group->filled_by,
                    'sort_order' => $group->sort_order,

                    'questions' => $group->questions->map(function ($q) {
                        return [
                            'id' => $q->id,
                            'question_code' => $q->question_code,
                            'question_number' => $q->question_number,
                            'question_text' => $q->question_text,
                            'answer_type' => $q->answer_type,
                            'answer_options' => $q->answer_options,
                            'answer_format' => $q->answer_format,
                            'extra_schema' => $q->extra_schema,
                        ];
                    }),
                ];
            }),
        ];
    }

    public function getAnswers(Assessment $assessment, string $type)
    {
        return $this->assessmentRepository->getHistoryByAssessmentId($assessment->id, $type);
    }

    public function storeOrUpdateParentAssessment(array $payload, Assessment $assessment, string $type)
    {
        $detail_type = str_replace('_parent', '', $type);

        $detail = $assessment->assessmentDetails()->where('type', $detail_type)->first();

        if (!$detail) {
            throw new \Exception("Asesmen dengan ID: {$assessment->id} tidak memiliki tipe {$detail_type}");
        }

        $this->validateConditional($payload['answers']);

        $this->assessmentRepository->saveParentAnswers($payload, $detail, $type);

        return true;
    }


    public function storeOrUpdateAssessorAssessment(array $payload, Assessment $assessment, string $type)
    {
        $assessor = $this->getAuthenticatedAssessor();

        $detail_type = str_replace('_assessor', '', $type);
        $detail = $assessment->assessmentDetails()->where('type', $detail_type)->first();

        if (!$detail) {
            throw new \Exception("Asesmen dengan ID: {$assessment->id} tidak memiliki tipe {$detail_type}");
        }

        if (!$this->isTherapistAllowed($assessor->therapist_section, $type)) {
            throw new \Exception("Terapis tidak memiliki izin untuk mengisi asesmen tipe: {$type}", 403);
        }

        $this->assessmentRepository->saveAssessorAnswers($payload, $detail, $type, $assessor);

        return true;
    }

    public function updateScheduledDate(array $data, Assessment $assessment)
    {
        $admin = $this->getAuthenticatedAdmin();

        if (!empty($data['scheduled_date']) && !empty($data['scheduled_time'])) {
            $newDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $data['scheduled_date'] . ' ' . $data['scheduled_time']
            );

            $this->assessmentDetailRepository->updateScheduledDate($assessment->id, $newDateTime, $admin);
        }
    }

    private function getAuthenticatedAdmin()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('Tidak ada pengguna yang terautentikasi.');
        }

        $admin = $user->admin;

        if (!$admin) {
            throw new \Exception('Profil admin tidak ditemukan untuk pengguna ini.');
        }

        return $admin;
    }

    private function getAuthenticatedAssessor()
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('Tidak ada pengguna yang terautentikasi.');
        }

        if ($user->role !== 'asesor') {
            throw new \Exception('Hanya akun dengan role asesor yang diizinkan mengisi asesmen.', 403);
        }

        $therapist = $user->therapist;

        if (!$therapist) {
            throw new \Exception('Profil terapis tidak ditemukan untuk pengguna ini.');
        }

        return $therapist;
    }

    private function isTherapistAllowed(string $section, string $assessmentType): bool
    {
        $map = [
            'fisio' => ['fisio', 'fisio_assessor'],
            'okupasi' => ['okupasi', 'okupasi_assessor'],
            'paedagog' => ['paedagog', 'paedagog_assessor'],
            'wicara' => ['wicara', 'wicara_assessor'],
        ];

        return in_array($assessmentType, $map[$section] ?? []);
    }

    private function validateAssessmentCompletion(Assessment $assessmentDetail)
    {
        $assessmentId = $assessmentDetail->assessment_id;

        $details = AssessmentDetail::where('assessment_id', $assessmentId)->get();

        $incomplete = $details->filter(function ($d) {
            return $d->parent_completed_status === 'pending';
        });

        if ($incomplete->isNotEmpty()) {
            throw new \Exception('Masih ada asesmen yang belum diselesaikan oleh terapis.');
        }

        return true;
    }


    private function validateConditional(array $answers)
    {
        $answer_collection = collect($answers);

        $questions_ids = $answer_collection->pluck('question_id');
        $questions = AssessmentQuestion::whereIn('id', $questions_ids)->get()->keyBy('id');

        foreach ($answers as $answer) {
            $question = $questions[$answer['question_id']] ?? null;

            if (!$question || !$question->extra_schema) continue;

            $extra = json_decode($question->extra_schema, true);
            if (!isset($extra['conditional_rules'])) continue;

            foreach ($extra['conditional_rules'] as $rule) {
                $this->applyConditionalRule($rule, $answer_collection, $answer['question_id']);
            }
        }
    }

    private function applyConditionalRule(array $rule, $answers, int $current_question_id)
    {
        $target = $answers->firstWhere('question_id', $rule['when']);

        if (!$target) return;

        $value = $target['answer'] ?? null;

        $passed = match ($rule['operator']) {
            '==' => $value == ($rule['value'] ?? null),
            '!=' => $value != ($rule['value'] ?? null),
            'not_empty' => !empty($value),
            default => true
        };

        if ($passed && ($rule['required'] ?? false)) {
            $current = collect($answers)->firstWhere('question_id', $current_question_id);

            if (!$current || empty($current['answer'])) {
                throw ValidationException::withMessages([
                    "answer" => ["Jawaban untuk question {$current_question_id} wajib diisi."]
                ]);
            }
        }
    }
}
