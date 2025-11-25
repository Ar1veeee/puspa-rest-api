<?php

namespace App\Http\Repositories;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentDetail;
use App\Models\AssessmentQuestionGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssessmentRepository
{
    protected $model;

    public function __construct(Assessment $model)
    {
        $this->model = $model;
    }

    public function getIdByObservationId(int $observationId)
    {
        return $this->model
            ->where('observation_id', $observationId)
            ->value('id');
    }

    public function getQuestionByType(string $assessment_type)
    {
        return AssessmentQuestionGroup::with(['questions' => function ($q) {
            $q->where('is_active', true)
                ->orderBy('question_number', 'asc');
        }])
            ->where('assessment_type', $assessment_type)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function getHistoryByAssessmentId(int $assessment_id, string $type)
    {
        return AssessmentAnswer::query()
            ->where('assessment_id', $assessment_id)
            ->where('type', $type)
            ->join('assessment_questions', 'assessment_questions.id', '=', 'assessment_answers.question_id')
            ->leftJoin('assessment_question_groups', 'assessment_question_groups.id', '=', 'assessment_questions.group_id')
            ->select(
                'assessment_questions.question_number',
                'assessment_answers.question_id',
                'assessment_questions.question_text',
                'assessment_questions.answer_type',
                'assessment_answers.answer_value',
                'assessment_questions.section',
                'assessment_question_groups.group_title',
                'assessment_question_groups.sort_order'
            )
            ->orderBy('assessment_question_groups.sort_order')
            ->orderBy('assessment_questions.question_number')
            ->get()
            ->groupBy('group_title');
    }

    public function saveAssessorAnswers(array $data, AssessmentDetail $detail, string $type, $assessor)
    {
        return DB::transaction(function () use ($detail, $data, $type, $assessor) {
            foreach ($data['answers'] as $item) {
                $value = $item['answer'];

                AssessmentAnswer::updateOrCreate(
                    [
                        'assessment_id' => $detail->assessment_id,
                        'question_id' => $item['question_id'],
                        'type' => $type,
                    ],
                    [
                        'answer_value' => is_array($value) ? json_encode($value) : $value,
                        'note' => $item['note'] ?? null,
                    ]
                );
            }

            $detail->update([
                'status' => 'completed',
                'therapist_id' => $assessor->id,
                'completed_at' => Carbon::now(),
            ]);

            return true;
        });
    }

    public function saveParentAnswers(array $data, AssessmentDetail $detail, string $type)
    {
        return DB::transaction(function () use ($detail, $data, $type) {

            foreach ($data['answers'] as $item) {

                $value = $item['answer'];

                AssessmentAnswer::updateOrCreate(
                    [
                        'assessment_id' => $detail->assessment_id,
                        'question_id' => $item['question_id'],
                        'type' => $type,
                    ],
                    [
                        'answer_value' => is_array($value) ? json_encode($value) : $value,
                        'note' => $item['note'] ?? null,
                    ]
                );
            }

            $detail->update([
                'parent_completed_status' => 'completed',
                'parent_completed_at' => Carbon::now(),
            ]);

            return true;
        });
    }
}
