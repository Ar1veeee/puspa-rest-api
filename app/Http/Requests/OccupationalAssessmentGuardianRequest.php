<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OccupationalAssessmentGuardianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $enumOptions = ['ya', 'tidak', 'kadang-kadang'];

        return [
            // occupational_auditory_communications
            'easily_disturbed_by_sound' => ['required', 'boolean'],
            'cannot_follow_simple_instructions' => ['required', 'boolean'],
            'confused_by_words' => ['required', 'boolean'],
            'only_uses_body_language' => ['required', 'boolean'],
            'likes_to_sing' => ['required', 'boolean'],
            'speech_sound_difficulty' => ['required', 'boolean'],
            'attentive_but_confused' => ['required', 'boolean'],
            'hesitant_to_speak' => ['required', 'boolean'],
            'understands_body_language_facial_expressions' => ['nullable', 'boolean'],

            // occupational_sensory_modality_tests
            // GUSTATORI/OLFAKTORI
            'gust_thinks_all_food_tastes_same' => ['required', 'string', Rule::in($enumOptions)],
            'gust_chews_non_food_items' => ['required', 'string', Rule::in($enumOptions)],
            'gust_selective_food_taste' => ['required', 'string', Rule::in($enumOptions)],
            'gust_dislikes_certain_food_textures' => ['required', 'string', Rule::in($enumOptions)],
            'gust_explores_with_smell' => ['required', 'string', Rule::in($enumOptions)],
            'gust_can_distinguish_smells' => ['required', 'string', Rule::in($enumOptions)],
            'gust_negative_reaction_to_smells' => ['required', 'string', Rule::in($enumOptions)],
            'gust_ignores_unpleasant_smells' => ['required', 'string', Rule::in($enumOptions)],
            // VISUAL
            'vis_prefers_darkness' => ['required', 'string', Rule::in($enumOptions)],
            'vis_points_at_objects_detailed' => ['required', 'string', Rule::in($enumOptions)],
            'vis_enjoys_variety_of_objects' => ['required', 'string', Rule::in($enumOptions)],
            'vis_often_spining' => ['required', 'string', Rule::in($enumOptions)],
            'vis_wears_glasses' => ['required', 'string', Rule::in($enumOptions)],
            'vis_difficulty_following_objects' => ['required', 'string', Rule::in($enumOptions)],
            'vis_difficulty_eye_contact' => ['required', 'string', Rule::in($enumOptions)],
            'vis_turns_head_side_to_side' => ['required', 'string', Rule::in($enumOptions)],
            'vis_reaches_too_far' => ['required', 'string', Rule::in($enumOptions)],
            // TAKTIL
            'tact_avoids_dirty_play' => ['required', 'string', Rule::in($enumOptions)],
            'tact_dislikes_face_wiping' => ['required', 'string', Rule::in($enumOptions)],
            'tact_bothered_by_fabric_textures' => ['required', 'string', Rule::in($enumOptions)],
            'tact_dislikes_being_touched' => ['required', 'string', Rule::in($enumOptions)],
            'tact_dislikes_suddeny_touch' => ['required', 'string', Rule::in($enumOptions)],
            'tact_dislikes_hugs' => ['required', 'string', Rule::in($enumOptions)],
            'tact_prefers_touching_over_being_touched' => ['required', 'string', Rule::in($enumOptions)],
            'tact_avoids_using_hands' => ['required', 'string', Rule::in($enumOptions)],
            'tact_deliberately_hurts_head' => ['required', 'string', Rule::in($enumOptions)],
            'tact_bites_or_hurts_self_others' => ['required', 'string', Rule::in($enumOptions)],
            'tact_explores_objects_with_mouth' => ['required', 'string', Rule::in($enumOptions)],
            'tact_feels_more_pain' => ['required', 'string', Rule::in($enumOptions)],
            'tact_hurts_other_children' => ['required', 'string', Rule::in($enumOptions)],
            'tact_dislikes_hair_washing' => ['required', 'string', Rule::in($enumOptions)],
            'tact_dislikes_nail_cutting' => ['required', 'string', Rule::in($enumOptions)],
            // PROPIOSEPTIF
            'prop_holds_hands_in_odd_position' => ['required', 'string', Rule::in($enumOptions)],
            'prop_holds_body_in_odd_position' => ['required', 'string', Rule::in($enumOptions)],
            'prop_good_at_imitating_small_things' => ['required', 'string', Rule::in($enumOptions)],
            'prop_makes_fast_repetitive_movements' => ['required', 'string', Rule::in($enumOptions)],
            'prop_difficulty_changing_positions' => ['required', 'string', Rule::in($enumOptions)],
            // VESTIBULAR
            'swinging_while_sitting' => ['required', 'string', Rule::in($enumOptions)],
            'jumps_a_lot' => ['required', 'string', Rule::in($enumOptions)],
            'enjoys_being_thrown_in_air' => ['required', 'string', Rule::in($enumOptions)],
            'has_good_balance' => ['required', 'string', Rule::in($enumOptions)],
            'fearful_of_spaces' => ['required', 'string', Rule::in($enumOptions)],
            'likes_carousel' => ['required', 'string', Rule::in($enumOptions)],
            'spins_more_than_other_children' => ['required', 'string', Rule::in($enumOptions)],
            'gets_car_sick' => ['required', 'string', Rule::in($enumOptions)],
            'enjoys_swinging' => ['required', 'string', Rule::in($enumOptions)],
            'not_afraid_of_falling' => ['required', 'string', Rule::in($enumOptions)],
            'restless_in_long_car_rides' => ['required', 'string', Rule::in($enumOptions)],

            // occupational_sensory_processing_screenings
            'disturbed_by_physical_contact_with_others' => ['required', 'boolean'],
            'dislikes_nail_trimming' => ['required', 'boolean'],
            'fear_in_balance_climbing_games' => ['required', 'boolean'],
            'excessive_spinning_swinging_games' => ['required', 'boolean'],
            'passive_when_at_home' => ['required', 'boolean'],
            'likes_to_be_hugged_and_bought' => ['required', 'boolean'],
            'puts_fingers_toys_in_mouth' => ['required', 'boolean'],
            'dislikes_certain_food_textures' => ['required', 'boolean'],
            'disturbed_by_loud_voices' => ['required', 'boolean'],
            'likes_to_touch_objects' => ['required', 'boolean'],
            'disturbed_by_certain_textures' => ['required', 'boolean'],
            'shows_extreme_dislike_to_something' => ['required', 'boolean'],

            // occupational_adl_motor_skills
            'difficulty_regulating_emotions' => ['required', 'boolean'],
            'difficulty_dressing' => ['required', 'boolean'],
            'difficulty_wearing_shoes_socks' => ['required', 'boolean'],
            'difficulty_tying_shoelaces' => ['required', 'boolean'],
            'difficulty_buttoning' => ['required', 'boolean'],
            'difficulty_self_cleaning' => ['required', 'boolean'],
            'difficulty_brushing_teeth' => ['required', 'boolean'],
            'difficulty_combing_hair' => ['required', 'boolean'],
            'difficulty_standing_on_one_leg' => ['required', 'boolean'],
            'difficulty_jumping_in_place' => ['required', 'boolean'],
            'difficulty_skipping_rope' => ['required', 'boolean'],
            'difficulty_riding_bike' => ['required', 'boolean'],
            'difficulty_using_playground_equipment' => ['required', 'boolean'],
            'difficulty_climbing_stairs' => ['required', 'boolean'],

            // occupational_behavior_socials
            'is_quiet' => ['required', 'boolean'],
            'is_hyperactive' => ['required', 'boolean'],
            'difficulty_managing_frustration' => ['required', 'boolean'],
            'is_impulsive' => ['required', 'boolean'],
            'attention_seeking' => ['required', 'boolean'],
            'withdrawn' => ['required', 'boolean'],
            'is_curious' => ['required', 'boolean'],
            'is_aggressive' => ['required', 'boolean'],
            'is_shy' => ['required', 'boolean'],
            'behavior_problems_at_home' => ['required', 'boolean'],
            'behavior_problems_at_school' => ['required', 'boolean'],
            'is_emotional' => ['required', 'boolean'],
            'unusual_fears' => ['required', 'boolean'],
            'frequent_tantrums' => ['required', 'boolean'],
            'good_relationship_with_siblings' => ['required', 'boolean'],
            'makes_friends_easily' => ['required', 'boolean'],
            'understands_game_rules' => ['required', 'boolean'],
            'understands_jokes' => ['required', 'boolean'],
            'is_rigid' => ['required', 'boolean'],
            'plays_with_other_children' => ['required', 'string', 'in:lebih tua,lebih muda,seumuran'],

            // occupational_behavior_scales
            'easy_to_surrender' => ['required', 'integer', 'between:1,6'],
            'distracted_by_attention' => ['required', 'integer', 'between:1,6'],
            'difficulty_sitting_quietly_5min' => ['required', 'integer', 'between:1,6'],
            'cannot_concentrate_20min' => ['required', 'integer', 'between:1,6'],
            'often_tries_to_forget_personal_belongings' => ['required', 'integer', 'between:1,6'],
            'responds_without_clear_reason' => ['required', 'integer', 'between:1,6'],
            'refuses_to_follow_orders_even_simple' => ['required', 'integer', 'between:1,6'],
            'not_patient_waiting_turn' => ['required', 'integer', 'between:1,6'],
        ];
    }
}
