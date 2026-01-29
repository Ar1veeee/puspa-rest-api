<?php

namespace App\Services;

use App\Actions\Assessment\StoreAssessorAssessmentAction;
use App\Actions\Assessment\StoreParentAssessmentAction;
use App\Actions\Assessment\UpdateScheduledDateAction;
use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestionGroup;
use App\Models\Guardian;
use Illuminate\Support\Facades\Cache;

class AssessmentService
{
    private const CACHE_QUESTIONS = 'assessment_questions_';

    public function __construct(
        private StoreParentAssessmentAction $storeParentAssessmentAction,
        private StoreAssessorAssessmentAction $storeAssessorAssessmentAction,
        private UpdateScheduledDateAction $updateScheduledDateAction,
    ) {}

    public function getAssessments(array $filters = [])
    {
        return $this->queryAssessments($filters);
    }

    private function queryAssessments(array $filters)
    {
        return Assessment::query()
            ->with([
                'child:id,family_id,child_name,child_birth_date,child_gender',
                'child.family.guardians:id,family_id,guardian_name,guardian_phone,guardian_type',
                'assessmentDetails' => function ($q) use ($filters) {
                    $q->with(['therapist:id,therapist_name', 'admin:id,admin_name'])
                        ->when($filters['type'] ?? null, fn($sub) => $sub->where('type', $filters['type']));
                },
            ])
            ->whereNotNull('scheduled_date')
            ->when($filters['status'] ?? null, function ($q, $status) {
                $q->where('parent_status', $status);
            })
            ->when($filters['date'] ?? null, fn($q, $date) => $q->whereDate('scheduled_date', $date))
            ->when(
                $filters['search'] ?? null,
                fn($q, $search) =>
                $q->whereHas('child', fn($c) => $c->where('child_name', 'like', "%{$search}%"))
            )
            ->when($filters['type'] ?? null, function ($q, $type) {
                $q->whereHas('assessmentDetails', fn($d) => $d->where('type', $type));
            })
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getAssessmentsByType(array $filters = [])
    {
        return Assessment::query()
            ->with([
                'assessmentDetails' => function ($q) use ($filters) {
                    $q->with(['therapist:id,therapist_name', 'admin:id,admin_name'])
                        ->when(isset($filters['type']), fn($sub) => $sub->where('type', $filters['type']));
                },
                'child:id,family_id,child_name',
                'child.family:id',
                'child.family.guardians',
            ])
            ->whereNotNull('scheduled_date')
            ->when(isset($filters['status']), function ($q) use ($filters) {
                $q->where('status', $filters['status']);
            })
            ->when(isset($filters['type']), function ($q) use ($filters) {
                $q->whereHas('assessmentDetails', fn($d) => $d->where('type', $filters['type']));
            })
            ->when(isset($filters['date']), fn($q) => $q->whereDate('scheduled_date', $filters['date']))
            ->when(isset($filters['search']), function ($q) use ($filters) {
                $q->whereHas('child', fn($c) => $c->where('child_name', 'like', "%{$filters['search']}%"));
            })
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }

    public function getQuestionsByType(string $type): array
    {
        $groups = Cache::remember(self::CACHE_QUESTIONS . $type, 3600, function () use ($type) {
            return AssessmentQuestionGroup::with('questions')
                ->where('assessment_type', $type)
                ->orderBy('sort_order')
                ->get();
        });

        return [
            'assessment_type' => $type,
            'groups' => $groups->map(fn($group) => [
                'group_id'     => $group->id,
                'group_key'    => $group->group_key,
                'title'        => $group->group_title,
                'filled_by'    => $group->filled_by,
                'sort_order'   => $group->sort_order,
                'questions'    => $group->questions->map(fn($q) => [
                    'id'              => $q->id,
                    'question_code'   => $q->question_code,
                    'question_number' => $q->question_number,
                    'question_text'   => $q->question_text,
                    'answer_type'     => $q->answer_type,
                    'answer_options'  => $q->answer_options,
                    'answer_format'   => $q->answer_format,
                    'extra_schema'    => $q->extra_schema,
                ]),
            ]),
        ];
    }

    public function getAnswers(Assessment $assessment, string $type)
    {
        $cacheKey = "answers_{$assessment->id}_{$type}";

        return Cache::remember($cacheKey, 1800, function () use ($assessment, $type) {
            $detailType = str_replace(['_parent', '_assessor'], '', $type);
            $detail = $assessment->assessmentDetails()->where('type', $detailType)->first();

            if (!$detail) return [];

            return AssessmentAnswer::where('assessment_detail_id', $detail->id)
                ->where('type', $type)
                ->select('id', 'question_id', 'answer_value', 'note')
                ->with('question:id,question_text')
                ->get()
                ->map(fn($answer) => [
                    'question_id'   => $answer->question_id,
                    'question_text' => $answer->question->question_text ?? null,
                    'answer'        => $answer->answer_value,
                    'note'          => $answer->note,
                ]);
        });
    }

    public function storeParentAssessment(Assessment $assessment, string $type, array $data): void
    {
        $this->storeParentAssessmentAction->execute($assessment, $type, $data);
        Cache::forget("answers_{$assessment->id}_{$type}");
    }

    public function storeAssessorAssessment(Assessment $assessment, string $type, array $data): void
    {
        $this->storeAssessorAssessmentAction->execute($assessment, $type, $data);
        Cache::forget("answers_{$assessment->id}_{$type}");
    }

    public function updateScheduledDate(Assessment $assessment, array $data): void
    {
        $this->updateScheduledDateAction->execute($assessment, $data);
    }

    public function getChildrenAssessment(string $userId)
    {
        return Cache::remember("guardian_{$userId}_children_assessments", 300, function () use ($userId) {
            $guardian = Guardian::where('user_id', $userId)->firstOrFail();

            return $guardian->family->children()
                ->whereHas('assessment')
                ->with(['assessment' => function ($query) {
                    $query->orderBy('scheduled_date', 'asc');
                }])
                ->get();
        });
    }
}
