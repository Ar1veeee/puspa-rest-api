<?php

namespace App\Actions\Assessment;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentDetail;
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
            ->first();

        if (!$detail) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'type' => ["Layanan {$detailType} tidak dijadwalkan untuk asesmen ini."]
            ]);
        }

        if ($detailType === 'wicara') {
            $questionIds = collect($payload['answers'])->pluck('question_id')->unique();
            $bahasaQuestions = AssessmentQuestion::whereIn('id', $questionIds)
                ->where('assessment_type', 'wicara_bahasa')
                ->get();

            if ($bahasaQuestions->isNotEmpty()) {
                $child = $assessment->child;
                $birthDate = Carbon::parse($child->child_birth_date);
                $ageInMonths = $birthDate->diffInMonths(now());

                $expectedSection = $this->determineAgeSection($ageInMonths);

                foreach ($bahasaQuestions as $question) {
                    if ($question->section !== $expectedSection) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'answers' => "Pertanyaan ID {$question->id} tidak sesuai dengan usia anak ({$ageInMonths} bulan - Kategori: " . str_replace('_', ' ', $expectedSection) . ")."
                        ]);
                    }
                }
            }
        }

        DB::transaction(function () use ($assessment, $detail, $payload, $type) {
            $questionIds = collect($payload['answers'])->pluck('question_id')->unique();
            $subTypes = AssessmentQuestion::whereIn('id', $questionIds)->pluck('assessment_type')->unique();

            AssessmentAnswer::where('assessment_detail_id', $detail->id)
                ->where('type', $type)
                ->whereHas('question', function ($q) use ($subTypes) {
                    $q->whereIn('assessment_type', $subTypes);
                })
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
                'completed_at' => now(),
                'therapist_id' => auth()->user()->therapist->id,
            ]);

            $hasIncompleteDetails = AssessmentDetail::where('assessment_id', $assessment->id)
                ->whereNull('completed_at')
                ->where('type', '!=', 'umum')
                ->exists();

            if (!$hasIncompleteDetails) {
                $assessment->update([
                    'status' => 'completed',
                ]);
            }

            // Clear Cache
            \Illuminate\Support\Facades\Cache::forget("guardian_" . $assessment->child->family->guardians->first()->user_id . "_children_assessments");
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
