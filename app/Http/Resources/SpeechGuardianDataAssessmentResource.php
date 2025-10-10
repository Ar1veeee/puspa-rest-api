<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeechGuardianDataAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'speech_problem_description' => $this->speech_problem_description,
            'communication_method' => $this->communication_method,
            'language_first_known_and_who' => $this->language_first_known_and_who,
            'main_cause' => $this->main_cause,
            'child_awareness' => $this->child_awareness,
            'child_awareness_detail' => $this->child_awareness_detail ?? null,
            'previous_speech_therapy' => $this->previous_speech_therapy,
            'previous_speech_therapy_detail' => $this->previous_speech_therapy_detail ?? null,
            'other_specialist' => $this->other_specialist,
            'other_specialist_detail' => $this->other_specialist_detail ?? null,
            'family_communication_disorders' => $this->family_communication_disorders,
            'family_communication_disorders_detail' => $this->family_communication_disorders_detail ?? null,
            'age_child_can_express_one_word' => $this->age_child_can_express_one_word ?? null,
            'age_child_can_express_two_words' => $this->age_child_can_express_two_words ?? null,
            'age_child_can_express_three_plus_words' => $this->age_child_can_express_three_plus_words ?? null,
            'age_child_can_express_sentences' => $this->age_child_can_express_sentences ?? null,
            'age_child_can_tell_stories' => $this->age_child_can_tell_stories ?? null,
            'feeding_difficulty' => $this->feeding_difficulty,
            'sound_response_description' => $this->sound_response_description,
        ];

        return $response;
    }
}
