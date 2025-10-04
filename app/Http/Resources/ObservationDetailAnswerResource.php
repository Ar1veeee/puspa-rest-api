<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationDetailAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $answerDetails = $this->observation_answer->map(function ($answer) {
            return [
                'question_number' => $answer->observation_question->question_number ?? null,
                'question_text' => $answer->observation_question->question_text ?? null,
                'answer' => $answer->answer,
                'score_earned' => $answer->score_earned,
                'note' => $answer->note,
            ];
        });

        return [
            'id' => $this->id,
            'age_category' => $this->age_category,
            'answer_details' => $answerDetails,
            'total_score' => $this->total_score,
            'conclusion' => $this->conclusion,
            'recommendation' => $this->recommendation,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
