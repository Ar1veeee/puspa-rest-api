<?php

namespace App\Http\Services;

use App\Http\Repositories\AssessmentDetailRepository;
use App\Http\Repositories\AssessmentRepository;
use App\Http\Repositories\GuardianRepository;
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

        $queryFilters['parent_status'] = $filters['status'];

        if (isset($filters['date'])) {
            $queryFilters['scheduled_date'] = $filters['date'];
        }

        if (isset($filters['search'])) {
            $queryFilters['search'] = $filters['search'];
        }

        return $this->assessmentDetailRepository->getParentsAssessmentWithFilter($queryFilters);
    }

    public function getAssessmentsByType(array $filters = [])
    {
        $queryFilters = [];

        if (isset($filters['type'])) {
            $queryFilters['type'] = $filters['type'];
        }

        if (isset($filters['date'])) {
            $queryFilters['scheduled_date'] = $filters['date'];
        }

        if (isset($filters['status'])) {
            $queryFilters['status'] = $filters['status'];
        }

        if (isset($filters['search'])) {
            $queryFilters['search'] = $filters['search'];
        }

        return $this->assessmentDetailRepository->getAssessmentWithFilter($queryFilters);
    }

    public function getQuestionsByType(string $type): array
    {
        $groups = $this->assessmentRepository->getQuestionByType($type);

        return [
            'assessment_type' => $type,
            'groups' => $groups->map(function ($group) {
                return [
                    'group_id'   => $group->id,
                    'group_key'  => $group->group_key,
                    'title'      => $group->group_title,
                    'filled_by'  => $group->filled_by,
                    'sort_order' => $group->sort_order,

                    'questions' => $group->questions->map(function ($q) {
                        return [
                            'id'             => $q->id,
                            'question_code'  => $q->question_code,
                            'question_number'=> $q->question_number,
                            'question_text'  => $q->question_text,
                            'answer_type'    => $q->answer_type,
                            'answer_options' => $q->answer_options,
                            'answer_format'  => $q->answer_format,
                            'extra_schema'   => $q->extra_schema,
                        ];
                    }),
                ];
            }),
        ];
    }


    public function getAnswers(AssessmentDetail $assessment_detail, string $type)
    {
        return $this->assessmentRepository->getHistoryByAssessmentId($assessment_detail->assessment_id, $type);
    }

    public function storeOrUpdateParentAssessment(array $payload, AssessmentDetail $assessment_detail, string $type)
    {
        $this->validateConditional($payload['answers']);

        $this->assessmentRepository->saveParentAnswers($payload, $assessment_detail->assessment_id, $type);

        return true;
    }

    public function storeOrUpdateAssessorAssessment(array $payload, AssessmentDetail $assessment_detail, string $type)
    {
        $assessor = $this->getAuthenticatedAssessor();

        if (!$this->isTherapistAllowed($assessor->therapist_section, $type)) {
            throw new \Exception("Terapis tidak memiliki izin untuk mengisi asesmen tipe: {$type}", 403);
        }

        $this->assessmentRepository->saveAssessorAnswers($payload, $assessment_detail->assessment_id, $type, $assessor);

        return true;
    }

    public function completedAssessment(AssessmentDetail $assessmentDetail)
    {
        $this->validateAssessmentCompletion($assessmentDetail);

        AssessmentDetail::where(['assessment_id' => $assessmentDetail->assessment_id])
            ->update([
                    'parent_status' => 'completed',
                    'parent_completed_at' => Carbon::now(),
                ]
            );
    }

    public function updateScheduledDate(array $data, AssessmentDetail $assessment)
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
            'fisio'    => ['fisio', 'fisio_assessor'],
            'okupasi'  => ['okupasi', 'okupasi_assessor'],
            'paedagog' => ['paedagog', 'paedagog_assessor'],
            'wicara'   => ['wicara_oral_assessor', 'wicara_bahasa_assessor'],
        ];

        return in_array($assessmentType, $map[$section] ?? []);
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

    private function validateAssessmentCompletion(AssessmentDetail $assessment)
    {
        $type = $assessment->type;
        $assessment_id = $assessment->assessment_id;


        if (!isset($this->requiredTablesMap[$type])) {
            throw ValidationException::withMessages([
                'type' => ['Tipe assessment tidak valid.']
            ]);
        }

        $requiredTables = $this->requiredTablesMap[$type];
        $missingForms = [];

        foreach ($requiredTables as $table) {
            $exists = DB::table($table)
                ->where('assessment_id', $assessment_id)
                ->exists();

            if (!$exists) {
                $missingForms[] = $this->tableLabels[$table] ?? $table;
            }
        }

        if (!empty($missingForms)) {
            throw ValidationException::withMessages([
                'incomplete_forms' => [
                    'Anda belum menyelesaikan form berikut: ' . implode(', ', $missingForms)
                ],
                'missing_forms' => $missingForms
            ]);
        }
    }
}
