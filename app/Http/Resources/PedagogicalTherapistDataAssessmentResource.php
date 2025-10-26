<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource Utama: PedaAssessmentTherapistResource
 */
class PedagogicalTherapistDataAssessmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'assessment_id' => $this->assessment_id,
            'therapist' => new TherapistResource($this->whenLoaded('therapist')),
            'peda_assessment_id' => $this->id,
            'summary' => $this->summary,
            'reading_aspect' => new PedaReadingAspectResource($this->whenLoaded('readingAspect')),
            'writing_aspect' => new PedaWritingAspectResource($this->whenLoaded('writingAspect')),
            'counting_aspect' => new PedaCountingAspectResource($this->whenLoaded('countingAspect')),
            'learning_readiness_aspect' => new PedaLearningReadinessAspectResource($this->whenLoaded('learningReadinessAspect')),
            'general_knowledge_aspect' => new PedaGeneralKnowledgeAspectResource($this->whenLoaded('generalKnowledgeAspect')),
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];
    }
}

class TherapistResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'therapist_name' => $this->therapist_name,
        ];
    }
}

/**
 * Resource Anak: PedaReadingAspectResource
 * (Tabel: peda_reading_aspects)
 */
class PedaReadingAspectResource extends JsonResource
{
    // Helper untuk mengelompokkan data
    private function getScoreDesc(string $prefix): array
    {
        return [
            'score' => $this->{$prefix . '_score'},
            'desc' => $this->{$prefix . '_desc'},
        ];
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'recognize_letters' => $this->getScoreDesc('recognize_letters'),
            'recognize_letter_symbols' => $this->getScoreDesc('recognize_letter_symbols'),
            'say_alphabet_in_order' => $this->getScoreDesc('say_alphabet_in_order'),
            'pronounce_letters_correctly' => $this->getScoreDesc('pronounce_letters_correctly'),
            'read_vowels' => $this->getScoreDesc('read_vowels'),
            'read_consonants' => $this->getScoreDesc('read_consonants'),
            'read_given_words' => $this->getScoreDesc('read_given_words'),
            'read_sentences' => $this->getScoreDesc('read_sentences'),
            'read_quickly' => $this->getScoreDesc('read_quickly'),
            'read_for_comprehension' => $this->getScoreDesc('read_for_comprehension'),
        ];
    }
}

/**
 * Resource Anak: PedaWritingAspectResource
 * (Tabel: peda_writing_aspects)
 */
class PedaWritingAspectResource extends JsonResource
{
    // Helper untuk mengelompokkan data
    private function getScoreDesc(string $prefix): array
    {
        return [
            'score' => $this->{$prefix . '_score'},
            'desc' => $this->{$prefix . '_desc'},
        ];
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hold_writing_tool' => $this->getScoreDesc('hold_writing_tool'),
            'write_straight_down' => $this->getScoreDesc('write_straight_down'),
            'write_straight_side' => $this->getScoreDesc('write_straight_side'),
            'write_curved_line' => $this->getScoreDesc('write_curved_line'),
            'write_letters_straight' => $this->getScoreDesc('write_letters_straight'),
            'copy_letters' => $this->getScoreDesc('copy_letters'),
            'write_own_name' => $this->getScoreDesc('write_own_name'),
            'recognize_and_write_words' => $this->getScoreDesc('recognize_and_write_words'),
            'write_upper_lower_case' => $this->getScoreDesc('write_upper_lower_case'),
            'differentiate_similar_letters' => $this->getScoreDesc('differentiate_similar_letters'),
            'write_simple_sentences' => $this->getScoreDesc('write_simple_sentences'),
            'write_story_from_picture' => $this->getScoreDesc('write_story_from_picture'),
        ];
    }
}

/**
 * Resource Anak: PedaCountingAspectResource
 * (Tabel: peda_counting_aspects)
 */
class PedaCountingAspectResource extends JsonResource
{
    // Helper untuk mengelompokkan data
    private function getScoreDesc(string $prefix): array
    {
        return [
            'score' => $this->{$prefix . '_score'},
            'desc' => $this->{$prefix . '_desc'},
        ];
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'recognize_numbers_1_10' => $this->getScoreDesc('recognize_numbers_1_10'),
            'count_concrete_objects' => $this->getScoreDesc('count_concrete_objects'),
            'compare_quantities' => $this->getScoreDesc('compare_quantities'),
            'recognize_math_symbols' => $this->getScoreDesc('recognize_math_symbols'),
            'operate_addition_subtraction' => $this->getScoreDesc('operate_addition_subtraction'),
            'operate_multiplication_division' => $this->getScoreDesc('operate_multiplication_division'),
            'use_counting_tools' => $this->getScoreDesc('use_counting_tools'),
        ];
    }
}

/**
 * Resource Anak: PedaLearningReadinessAspectResource
 * (Tabel: peda_learning_readiness_aspects)
 */
class PedaLearningReadinessAspectResource extends JsonResource
{
    // Helper untuk mengelompokkan data
    private function getScoreDesc(string $prefix): array
    {
        return [
            'score' => $this->{$prefix . '_score'},
            'desc' => $this->{$prefix . '_desc'},
        ];
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'follow_instructions' => $this->getScoreDesc('follow_instructions'),
            'sit_calmly' => $this->getScoreDesc('sit_calmly'),
            'not_hyperactive' => $this->getScoreDesc('not_hyperactive'),
            'show_initiative' => $this->getScoreDesc('show_initiative'),
            'is_cooperative' => $this->getScoreDesc('is_cooperative'),
            'show_enthusiasm' => $this->getScoreDesc('show_enthusiasm'),
            'complete_tasks' => $this->getScoreDesc('complete_tasks'),
        ];
    }
}

/**
 * Resource Anak: PedaGeneralKnowledgeAspectResource
 * (Tabel: peda_general_knowledge_aspects)
 */
class PedaGeneralKnowledgeAspectResource extends JsonResource
{
    // Helper untuk mengelompokkan data
    private function getScoreDesc(string $prefix): array
    {
        return [
            'score' => $this->{$prefix . '_score'},
            'desc' => $this->{$prefix . '_desc'},
        ];
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'knows_identity' => $this->getScoreDesc('knows_identity'),
            'show_body_parts' => $this->getScoreDesc('show_body_parts'),
            'understand_taste_differences' => $this->getScoreDesc('understand_taste_differences'),
            'identify_colors' => $this->getScoreDesc('identify_colors'),
            'understand_sizes' => $this->getScoreDesc('understand_sizes'),
            'understand_orientation' => $this->getScoreDesc('understand_orientation'),
            'express_emotions' => $this->getScoreDesc('express_emotions'),
        ];
    }
}
