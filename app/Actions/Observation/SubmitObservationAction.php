<?php

namespace App\Actions\Observation;

use App\Events\ObservationUpdated;
use App\Models\Observation;
use App\Models\ObservationAnswer;
use App\Models\ObservationQuestion;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use Illuminate\Support\Facades\DB;

class SubmitObservationAction
{
    public function execute(Observation $observation, array $data): Observation
    {
        if ($observation->status === 'completed') {
            throw new \Exception('Observasi sudah diselesaikan.');
        }

        $questionIds = collect($data['answers'])->pluck('question_id')->unique();
        $questions = ObservationQuestion::findMany($questionIds)->keyBy('id');

        foreach ($data['answers'] as $answer) {
            $question = $questions->get($answer['question_id']);
            if (!$question || $question->age_category !== $observation->age_category) {
                throw new \Exception("Pertanyaan tidak sesuai kategori usia.");
            }
        }

        $therapist = auth()->user()->therapist;

        return DB::transaction(function () use ($observation, $data, $questions, $therapist) {
            $totalScore = 0;
            $answersToInsert = [];

            foreach ($data['answers'] as $answer) {
                $question = $questions->get($answer['question_id']);
                $score = ($answer['answer'] === true) ? $question->score : 0;
                $totalScore += $score;

                $answersToInsert[] = [
                    'observation_id' => $observation->id,
                    'question_id'    => $answer['question_id'],
                    'answer'         => $answer['answer'],
                    'score_earned'   => $score,
                    'note'           => $answer['note'] ?? null,
                ];
            }

            if ($answersToInsert) {
                ObservationAnswer::insert($answersToInsert);
            }

            $observation->update([
                'therapist_id'   => $therapist->id,
                'completed_at'   => now(),
                'total_score'    => $totalScore,
                'conclusion'     => $data['conclusion'],
                'recommendation' => $data['recommendation'],
                'status'         => 'completed',
            ]);

            $this->createAssessment($observation, $data);

            event(new ObservationUpdated($observation));

            return $observation->fresh();
        });
    }

    private function createAssessment(Observation $observation, array $data): void
    {
        $assessment = Assessment::create([
            'observation_id' => $observation->id,
            'child_id'       => $observation->child_id,
        ]);

        $types = ['umum'];
        if ($data['fisio'] ?? false) $types[] = 'fisio';
        if ($data['okupasi'] ?? false) $types[] = 'okupasi';
        if ($data['wicara'] ?? false) $types[] = 'wicara';
        if ($data['paedagog'] ?? false) $types[] = 'paedagog';

        $details = collect($types)->map(fn($type) => [
            'assessment_id' => $assessment->id,
            'type'          => $type,
            'status'        => 'pending',
            'created_at'    => now(),
            'updated_at'    => now(),
        ])->toArray();

        AssessmentDetail::insert($details);
    }
}

