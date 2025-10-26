<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="ObservationQuestionResource",
 * type="object",
 * @OA\Property(property="id", type="integer", description="Question ID"),
 * @OA\Property(property="question_code", type="string", description="Unique code for the question"),
 * @OA\Property(property="age_category", type="string", description="Applicable age category for the question"),
 * @OA\Property(property="question_number", type="integer", description="Sequential number of the question within its category"),
 * @OA\Property(property="question_text", type="string", description="The text of the question"),
 * @OA\Property(property="score", type="integer", description="The score value of the question if answered positively")
 * )
 */
class ObservationQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            "question_id" => $this->id,
            'question_code' => $this->question_code,
            'age_category' => $this->age_category,
            'question_number' => $this->question_number,
            'question_text' => $this->question_text,
            'score' => $this->score,
        ];

        return $response;
    }
}
