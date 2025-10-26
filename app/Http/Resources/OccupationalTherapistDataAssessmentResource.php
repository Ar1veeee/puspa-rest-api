<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

    /**
     * Resource Utama: OccuAssessmentTherapistResource
     * (Tabel: occu_assessment_therapists)
     */
class OccupationalTherapistDataAssessmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'assessment_id' => $this->assessment_id,
            'therapist' => new TherapistResource($this->whenLoaded('therapist')),
            'occu_assessment_id' => $this->id,
            'note' => $this->note,
            'assessment_result' => $this->assessment_result,
            'therapy_recommendation' => $this->therapy_recommendation,
            'bodily_self_sense' => new OccuBodilySelfSenseResource($this->whenLoaded('bodilySelfSense')),
            'balance_coordination' => new OccuBalanceCoordinationResource($this->whenLoaded('balanceCoordination')),
            'concentration_problem_solving' => new OccuConcentrationProblemSolvingResource($this->whenLoaded('concentrationProblemSolving')),
            'concept_knowledge' => new OccuConceptKnowledgeResource($this->whenLoaded('conceptKnowledge')),
            'motoric_planning' => new OccuMotoricPlanningResource($this->whenLoaded('motoricPlanning')),
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
 * Resource Anak: OccuBodilySelfSenseResource
 * (Tabel: occu_bodily_self_senses)
 */
class OccuBodilySelfSenseResource extends JsonResource
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
            'temperament' => [
                'alertness' => $this->getScoreDesc('temperament_alertness'),
                'cooperative' => $this->getScoreDesc('temperament_cooperative'),
                'shyness' => $this->getScoreDesc('temperament_shyness'),
                'easily_offended' => $this->getScoreDesc('temperament_easily_offended'),
                'happiness' => $this->getScoreDesc('temperament_happiness'),
                'physically_fit' => $this->getScoreDesc('temperament_physically_fit'),
            ],
            'behavior' => [
                'active' => $this->getScoreDesc('behavior_active'),
                'aggressive' => $this->getScoreDesc('behavior_aggressive'),
                'tantrum' => $this->getScoreDesc('behavior_tantrum'),
                'self_aware' => $this->getScoreDesc('behavior_self_aware'),
                'impulsive' => $this->getScoreDesc('behavior_impulsive'),
            ],
            'identity' => [
                'nickname' => $this->getScoreDesc('identity_nickname'),
                'full_name' => $this->getScoreDesc('identity_full_name'),
                'age' => $this->getScoreDesc('identity_age'),
            ],
        ];
    }
}

/**
 * Resource Anak: OccuBalanceCoordinationResource
 * (Tabel: occu_balance_coordinations)
 */
class OccuBalanceCoordinationResource extends JsonResource
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
            'left_right_discrimination' => $this->getScoreDesc('left_right_discrimination'),
            'spatial_position' => [
                'up_down' => $this->getScoreDesc('spatial_position_up_down'),
                'out_in' => $this->getScoreDesc('spatial_position_out_in'),
                'front_back' => $this->getScoreDesc('spatial_position_front_back'),
                'middle_edge' => $this->getScoreDesc('spatial_position_middle_edge'),
            ],
            'gross_motor' => [
                'walk_forward' => $this->getScoreDesc('gross_motor_walk_forward'),
                'walk_backward' => $this->getScoreDesc('gross_motor_walk_backward'),
                'walk_sideways' => $this->getScoreDesc('gross_motor_walk_sideways'),
                'tiptoe' => $this->getScoreDesc('gross_motor_tiptoe'),
                'running' => $this->getScoreDesc('gross_motor_running'),
                'stand_one_foot' => $this->getScoreDesc('gross_motor_stand_one_foot'),
                'jump_one_foot' => $this->getScoreDesc('gross_motor_jump_one_foot'),
            ],
        ];
    }
}

/**
 * Resource Anak: OccuConcentrationProblemSolvingResource
 * (Tabel: occu_concentration_problem_solvings)
 * (Ini adalah resource yang Anda minta di prompt sebelumnya)
 */
class OccuConcentrationProblemSolvingResource extends JsonResource
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
            'concentration' => [
                '2_commands' => $this->getScoreDesc('concentration_2_commands'),
                '3_commands' => $this->getScoreDesc('concentration_3_commands'),
                '4_commands' => $this->getScoreDesc('concentration_4_commands'),
                'find_in_picture' => $this->getScoreDesc('concentration_find_in_picture'),
            ],
            'problem_solving' => [
                'puzzle' => $this->getScoreDesc('problem_solving_puzzle'),
                'story' => $this->getScoreDesc('problem_solving_story'),
            ],
            'size_comprehension' => [
                'big_small' => $this->getScoreDesc('size_comprehension_big_small'),
                'tall_short' => $this->getScoreDesc('size_comprehension_tall_short'),
                'many_few' => $this->getScoreDesc('size_comprehension_many_few'),
                'long_short' => $this->getScoreDesc('size_comprehension_long_short'),
            ],
            'number_recognition' => [
                'count_forward' => $this->getScoreDesc('number_recognition_count_forward'),
                'count_backward' => $this->getScoreDesc('number_recognition_count_backward'),
                'symbol' => $this->getScoreDesc('number_recognition_symbol'),
                'concept' => $this->getScoreDesc('number_recognition_concept'),
            ],
        ];
    }
}

/**
 * Resource Anak: OccuConceptKnowledgeResource
 * (Tabel: occu_concept_knowledges)
 */
class OccuConceptKnowledgeResource extends JsonResource
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
            'letter_recognition' => [
                'pointing' => $this->getScoreDesc('letter_recognition_pointing'),
                'reading' => $this->getScoreDesc('letter_recognition_reading'),
                'writing' => $this->getScoreDesc('letter_recognition_writing'),
                'write_on_board' => $this->getScoreDesc('letter_recognition_write_on_board'),
                'write_in_order' => $this->getScoreDesc('letter_recognition_write_in_order'),
            ],
            'color_comprehension' => [
                'pointing' => $this->getScoreDesc('color_comprehension_pointing'),
                'differentiating' => $this->getScoreDesc('color_comprehension_differentiating'),
            ],
            'body_awareness' => [
                'mentioning' => $this->getScoreDesc('body_awareness_mentioning'),
                'pointing' => $this->getScoreDesc('body_awareness_pointing'),
            ],
            'time_orientation' => [
                'day_night' => $this->getScoreDesc('time_orientation_day_night'),
                'days' => $this->getScoreDesc('time_orientation_days'),
                'date_month_year' => $this->getScoreDesc('time_orientation_date_month_year'),
            ],
        ];
    }
}

/**
 * Resource Anak: OccuMotoricPlanningResource
 * (Tabel: occu_motoric_plannings)
 */
class OccuMotoricPlanningResource extends JsonResource
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
            'bilateral_skill' => [
                'stringing_beads' => $this->getScoreDesc('bilateral_skill_stringing_beads'),
                'flipping_pages' => $this->getScoreDesc('bilateral_skill_flipping_pages'),
                'sewing' => $this->getScoreDesc('bilateral_skill_sewing'),
            ],
            'cutting' => [
                'no_line' => $this->getScoreDesc('cutting_no_line'),
                'straight_line' => $this->getScoreDesc('cutting_straight_line'),
                'zigzag_line' => $this->getScoreDesc('cutting_zigzag_line'),
                'wave_line' => $this->getScoreDesc('cutting_wave_line'),
                'box_shape' => $this->getScoreDesc('cutting_box_shape'),
            ],
            'memory' => [
                'recall_objects' => $this->getScoreDesc('memory_recall_objects'),
                'singing' => $this->getScoreDesc('memory_singing'),
            ],
        ];
    }
}
