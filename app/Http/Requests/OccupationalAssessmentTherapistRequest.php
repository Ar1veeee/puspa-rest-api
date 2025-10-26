<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OccupationalAssessmentTherapistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'terapis';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $scoreRules = ['required', 'integer', 'between:0,3'];
        $descRules = ['nullable', 'string'];

        return [
            // Section I: Sense of Bodily Self
            'temperament_alertness_score' => $scoreRules,
            'temperament_alertness_desc' => $descRules,
            'temperament_cooperative_score' => $scoreRules,
            'temperament_cooperative_desc' => $descRules,
            'temperament_shyness_score' => $scoreRules,
            'temperament_shyness_desc' => $descRules,
            'temperament_easily_offended_score' => $scoreRules,
            'temperament_easily_offended_desc' => $descRules,
            'temperament_happiness_score' => $scoreRules,
            'temperament_happiness_desc' => $descRules,
            'temperament_physically_fit_score' => $scoreRules,
            'temperament_physically_fit_desc' => $descRules,
            'behavior_active_score' => $scoreRules,
            'behavior_active_desc' => $descRules,
            'behavior_aggressive_score' => $scoreRules,
            'behavior_aggressive_desc' => $descRules,
            'behavior_tantrum_score' => $scoreRules,
            'behavior_tantrum_desc' => $descRules,
            'behavior_self_aware_score' => $scoreRules,
            'behavior_self_aware_desc' => $descRules,
            'behavior_impulsive_score' => $scoreRules,
            'behavior_impulsive_desc' => $descRules,
            'identity_nickname_score' => $scoreRules,
            'identity_nickname_desc' => $descRules,
            'identity_full_name_score' => $scoreRules,
            'identity_full_name_desc' => $descRules,
            'identity_age_score' => $scoreRules,
            'identity_age_desc' => $descRules,

            // Section A: Balance & Coordination
            'left_right_discrimination_score' => $scoreRules,
            'left_right_discrimination_desc' => $descRules,
            'spatial_position_up_down_score' => $scoreRules,
            'spatial_position_up_down_desc' => $descRules,
            'spatial_position_out_in_score' => $scoreRules,
            'spatial_position_out_in_desc' => $descRules,
            'spatial_position_front_back_score' => $scoreRules,
            'spatial_position_front_back_desc' => $descRules,
            'spatial_position_middle_edge_score' => $scoreRules,
            'spatial_position_middle_edge_desc' => $descRules,
            'gross_motor_walk_forward_score' => $scoreRules,
            'gross_motor_walk_forward_desc' => $descRules,
            'gross_motor_walk_backward_score' => $scoreRules,
            'gross_motor_walk_backward_desc' => $descRules,
            'gross_motor_walk_sideways_score' => $scoreRules,
            'gross_motor_walk_sideways_desc' => $descRules,
            'gross_motor_tiptoe_score' => $scoreRules,
            'gross_motor_tiptoe_desc' => $descRules,
            'gross_motor_running_score' => $scoreRules,
            'gross_motor_running_desc' => $descRules,
            'gross_motor_stand_one_foot_score' => $scoreRules,
            'gross_motor_stand_one_foot_desc' => $descRules,
            'gross_motor_jump_one_foot_score' => $scoreRules,
            'gross_motor_jump_one_foot_desc' => $descRules,

            // Section B: Concentration & Problem Solving
            'concentration_2_commands_score' => $scoreRules,
            'concentration_2_commands_desc' => $descRules,
            'concentration_3_commands_score' => $scoreRules,
            'concentration_3_commands_desc' => $descRules,
            'concentration_4_commands_score' => $scoreRules,
            'concentration_4_commands_desc' => $descRules,
            'concentration_find_in_picture_score' => $scoreRules,
            'concentration_find_in_picture_desc' => $descRules,
            'problem_solving_puzzle_score' => $scoreRules,
            'problem_solving_puzzle_desc' => $descRules,
            'problem_solving_story_score' => $scoreRules,
            'problem_solving_story_desc' => $descRules,
            'size_comprehension_big_small_score' => $scoreRules,
            'size_comprehension_big_small_desc' => $descRules,
            'size_comprehension_tall_short_score' => $scoreRules,
            'size_comprehension_tall_short_desc' => $descRules,
            'size_comprehension_many_few_score' => $scoreRules,
            'size_comprehension_many_few_desc' => $descRules,
            'size_comprehension_long_short_score' => $scoreRules,
            'size_comprehension_long_short_desc' => $descRules,
            'number_recognition_count_forward_score' => $scoreRules,
            'number_recognition_count_forward_desc' => $descRules,
            'number_recognition_count_backward_score' => $scoreRules,
            'number_recognition_count_backward_desc' => $descRules,
            'number_recognition_symbol_score' => $scoreRules,
            'number_recognition_symbol_desc' => $descRules,
            'number_recognition_concept_score' => $scoreRules,
            'number_recognition_concept_desc' => $descRules,

            // Section C: Concept Knowledge
            'letter_recognition_pointing_score' => $scoreRules,
            'letter_recognition_pointing_desc' => $descRules,
            'letter_recognition_reading_score' => $scoreRules,
            'letter_recognition_reading_desc' => $descRules,
            'letter_recognition_writing_score' => $scoreRules,
            'letter_recognition_writing_desc' => $descRules,
            'letter_recognition_write_on_board_score' => $scoreRules,
            'letter_recognition_write_on_board_desc' => $descRules,
            'letter_recognition_write_in_order_score' => $scoreRules,
            'letter_recognition_write_in_order_desc' => $descRules,
            'color_comprehension_pointing_score' => $scoreRules,
            'color_comprehension_pointing_desc' => $descRules,
            'color_comprehension_differentiating_score' => $scoreRules,
            'color_comprehension_differentiating_desc' => $descRules,
            'body_awareness_mentioning_score' => $scoreRules,
            'body_awareness_mentioning_desc' => $descRules,
            'body_awareness_pointing_score' => $scoreRules,
            'body_awareness_pointing_desc' => $descRules,
            'time_orientation_day_night_score' => $scoreRules,
            'time_orientation_day_night_desc' => $descRules,
            'time_orientation_days_score' => $scoreRules,
            'time_orientation_days_desc' => $descRules,
            'time_orientation_date_month_year_score' => $scoreRules,
            'time_orientation_date_month_year_desc' => $descRules,

            // Section D: Motoric Planning
            'bilateral_skill_stringing_beads_score' => $scoreRules,
            'bilateral_skill_stringing_beads_desc' => $descRules,
            'bilateral_skill_flipping_pages_score' => $scoreRules,
            'bilateral_skill_flipping_pages_desc' => $descRules,
            'bilateral_skill_sewing_score' => $scoreRules,
            'bilateral_skill_sewing_desc' => $descRules,
            'cutting_no_line_score' => $scoreRules,
            'cutting_no_line_desc' => $descRules,
            'cutting_straight_line_score' => $scoreRules,
            'cutting_straight_line_desc' => $descRules,
            'cutting_zigzag_line_score' => $scoreRules,
            'cutting_zigzag_line_desc' => $descRules,
            'cutting_wave_line_score' => $scoreRules,
            'cutting_wave_line_desc' => $descRules,
            'cutting_box_shape_score' => $scoreRules,
            'cutting_box_shape_desc' => $descRules,
            'memory_recall_objects_score' => $scoreRules,
            'memory_recall_objects_desc' => $descRules,
            'memory_singing_score' => $scoreRules,
            'memory_singing_desc' => $descRules,

            // Final Summary Fields
            'note' => ['nullable', 'string'],
            'assessment_result' => ['nullable', 'string'],
            'therapy_recommendation' => ['nullable', 'string'],
        ];
    }
}
