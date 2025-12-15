<?php

namespace App\Actions\Assessment;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use Illuminate\Support\Facades\DB;

class StoreAssessorAssessmentAction
{
    public function execute(Assessment $assessment, string $type, array $payload): void
    {
        $detailType = str_replace('_assessor', '', $type);

        $detail = $assessment->assessmentDetails()->where('type', $detailType)->firstOrFail();

        DB::transaction(function () use ($detail, $payload, $type) {
            // AssessmentAnswer::where('assessment_detail_id', $detail->id)->delete();

            $answers = collect($payload['answers'])->map(function ($a) use ($detail, $type) {
                $answerValue = $a['answer'];

                if (is_array($answerValue)) {
                    $answerValue = json_encode($answerValue);
                }

                return [
                    'assessment_detail_id' => $detail->id,
                    'type' => $type,
                    'question_id' => $a['question_id'],
                    'answer_value' => $answerValue,
                    'note' => $a['note'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            AssessmentAnswer::insert($answers);

            $detail->update([
                'status'       => 'completed',
                'completed_at' => now(),
                'therapist_id' => auth()->user()->therapist->id,
            ]);
        });
    }
}
