<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'question_code' => $this->question_code,
            'age_category' => $this->age_category,
            'question_number' => $this->question_number,
            'question_text' => $this->question_text,
            'score' => $this->score,
        ];
    }
}
