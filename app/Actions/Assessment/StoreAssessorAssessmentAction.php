<?php

namespace App\Actions\Assessment;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StoreAssessorAssessmentAction
{
    public function execute(Assessment $assessment, string $type, array $payload): void
    {
        $detailType = str_replace('_assessor', '', $type);

        $detail = $assessment->assessmentDetails()
            ->where('type', $detailType)
            ->firstOrFail();

        if ($detailType === 'wicara') {
            $child = $assessment->child;

            $birthDate = Carbon::parse($child->child_birth_date);
            $ageInMonths = $birthDate->diffInMonths(now());

            $expectedSection = $this->determineAgeSection($ageInMonths);

            $validQuestionIds = AssessmentQuestion::where('assessment_type', $detailType)
                ->where('section', $expectedSection)
                ->pluck('id')
                ->toArray();

            foreach ($payload['answers'] as $answer) {
                if (!in_array($answer['question_id'], $validQuestionIds)) {
                    throw ValidationException::withMessages([
                        'answers' => "Pertanyaan ID {$answer['question_id']} tidak sesuai dengan usia anak ({$ageInMonths} bulan - Section: {$expectedSection})."
                    ]);
                }
            }
        }

        DB::transaction(function () use ($detail, $payload, $type) {
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
                'status' => 'completed',
                'completed_at' => now(),
                'therapist_id' => auth()->user()->therapist->id,
            ]);
        });
    }

    private function determineAgeSection(int $months): string
    {
        if ($months >= 0 && $months <= 6) {
            return 'usia_0_6';
        } elseif ($months >= 7 && $months <= 12) {
            return 'usia_7_12';
        } elseif ($months >= 13 && $months <= 18) {
            return 'usia_13_18';
        } elseif ($months >= 19 && $months <= 24) {
            return 'usia_19_24';
        } elseif ($months >= 25 && $months <= 36) {
            return 'usia_2_3';
        } elseif ($months >= 37 && $months <= 48) {
            return 'usia_3_4';
        } elseif ($months >= 49 && $months <= 60) {
            return 'usia_4_5';
        } elseif ($months >= 61 && $months <= 72) {
            return 'usia_5_6';
        } elseif ($months >= 73 && $months <= 84) {
            return 'usia_6_7';
        }

        return 'usia_6_7';
    }
}
