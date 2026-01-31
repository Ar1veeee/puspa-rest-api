<?php

namespace App\Actions\Assessment;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentDetail;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StoreParentAssessmentAction
{
    public function execute(Assessment $assessment, string $type, array $payload): void
    {
        $detailType = str_replace('_parent', '', $type);

        $detail = $assessment->assessmentDetails()->where('type', $detailType)->first();

        if (!$detail) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'type' => ["Layanan {$detailType} tidak dijadwalkan untuk asesmen ini."]
            ]);
        }

        DB::transaction(function () use ($assessment, $detail, $payload, $type, $detailType) {
            $this->validateConditional($payload['answers']);    

            // Validasi: Pastikan semua question_id sesuai dengan tipe kuesioner
            $questionIds = collect($payload['answers'])->pluck('question_id')->unique();

            // Mapping: sesuaikan nama tipe submit dengan nama tipe di database questions
            $expectedQuestionType = ($type === 'umum_parent') ? 'parent_general' : 'parent_' . $detailType;

            $invalidQuestions = AssessmentQuestion::whereIn('id', $questionIds)
                ->where('assessment_type', '!=', $expectedQuestionType)
                ->exists();

            if ($invalidQuestions) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'answers' => ["Terdapat pertanyaan yang tidak sesuai dengan kategori " . str_replace('_', ' ', $type)]
                ]);
            }

            AssessmentAnswer::where('assessment_detail_id', $detail->id)
                ->where('type', $type)
                ->delete();

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
                'parent_completed_at' => now(),
            ]);

            $hasIncompleteDetails = AssessmentDetail::where('assessment_id', $assessment->id)
                ->whereNull('parent_completed_at')
                ->exists();

            if (!$hasIncompleteDetails) {
                $assessment->update([
                    'parent_status' => 'completed',
                ]);
            }

            // Clear cache daftar asesmen orang tua
            \Illuminate\Support\Facades\Cache::forget("guardian_" . auth()->id() . "_children_assessments");
        });
    }

    private function validateConditional(array $answers): void
    {
        $collection = collect($answers);
        $questions = AssessmentQuestion::whereIn('id', $collection->pluck('question_id'))->get()->keyBy('id');

        foreach ($answers as $answer) {
            $question = $questions[$answer['question_id']] ?? null;
            if (!$question || !$question->extra_schema) continue;

            $extra = json_decode($question->extra_schema, true);
            if (!isset($extra['conditional_rules'])) continue;

            foreach ($extra['conditional_rules'] as $rule) {
                $target = $collection->firstWhere('question_id', $rule['when']);
                $value = $target['answer'] ?? null;

                $passed = match ($rule['operator']) {
                    '==' => $value == ($rule['value'] ?? null),
                    '!=' => $value != ($rule['value'] ?? null),
                    'not_empty' => !empty($value),
                    default => true,
                };

                if ($passed && ($rule['required'] ?? false)) {
                    $current = $collection->firstWhere('question_id', $answer['question_id']);
                    if (!$current || empty($current['answer'])) {
                        throw ValidationException::withMessages([
                            "answer" => ["Jawaban untuk pertanyaan {$answer['question_id']} wajib diisi."]
                        ]);
                    }
                }
            }
        }
    }
}
