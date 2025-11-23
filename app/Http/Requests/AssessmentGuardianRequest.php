<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AssessmentGuardianRequest extends FormRequest
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
        $type = $this->input('type');

        $baseRules = [
            'type' => ['required', 'string', 'in:umum,fisio,wicara,okupasi,paedagog'],
        ];

        $typeSpecificRules = match ($type) {
            'umum' => $this->getGeneralRules(),
            'fisio' => $this->getPhysioRules(),
            'wicara' => $this->getSpeechRules(),
            'okupasi' => $this->getOccupationalRules(),
            'paedagog' => $this->getPedagogicalRules(),
            default => [],
        };

        return array_merge($baseRules, $typeSpecificRules);
    }

    private function getGeneralRules(): array
    {
        return [
            'child_order' => ['required', 'integer', 'min:1'],
            'siblings' => ['nullable', 'array'],
            'siblings.*.name' => ['required', 'string'],
            'siblings.*.age' => ['required', 'integer', 'min:0'],
            'household_members' => ['required', 'string'],
            'parent_marriage_status' => ['required', 'string', Rule::in(['menikah', 'cerai', 'lainya'])],
            'daily_language' => ['required', 'string', 'max:50'],

            'pregnancy_desired' => ['required', 'boolean'],
            'routine_checkup' => ['required', 'boolean'],
            'mother_age_at_pregnancy' => ['required', 'integer', 'min:1'],
            'pregnancy_duration' => ['required', 'integer', 'min:1'],
            'pregnancy_hemoglobin' => ['required', 'integer', 'min:1'],
            'pregnancy_incidents' => ['required', 'string'],
            'medication_consumption' => ['required', 'string'],
            'pregnancy_complications' => ['required', 'string'],

            'birth_type' => ['required', 'string', Rule::in(['normal', 'operasi caesar', 'vakum'])],
            'if_normal' => [
                'nullable',
                Rule::requiredIf($this->input('birth_type') === 'normal'),
                'string',
                Rule::in(['kepala dulu', 'kaki dulu', 'pantat dulu'])
            ],
            'caesar_vacuum_reason' => [
                'nullable',
                Rule::requiredIf(fn() => in_array($this->input('birth_type'), ['operasi caesar', 'vakum'])),
                'string'
            ],
            'crying_immediately' => ['required', 'boolean'],
            'birth_condition' => ['nullable', 'string', Rule::in(['biru', 'kuning', 'kejang'])],
            'birth_condition_duration' => [
                'nullable',
                Rule::requiredIf($this->input('birth_condition') === 'biru' || $this->input('birth_condition') === 'kuning' || $this->input('birth_condition') === 'kejang'),
                'integer',
                'min:0'
            ],
            'incubator_used' => ['required', 'boolean'],
            'incubator_duration' => [
                'nullable',
                Rule::requiredIf($this->input('incubator_used') == true),
                'integer',
                'min:0'
            ],
            'birth_weight' => ['nullable', 'numeric', 'min:0'],
            'birth_length' => ['nullable', 'integer', 'min:0'],
            'head_circumference' => ['nullable', 'numeric', 'min:0'],
            'birth_complications_other' => ['nullable', 'string'],
            'postpartum_depression' => ['required', 'boolean'],
            'postbirth_condition' => ['nullable', 'string', Rule::in(['biru', 'kuning', 'kejang'])],
            'postbirth_condition_duration' => [
                'nullable',
                Rule::requiredIf($this->input('postbirth_condition') === 'biru' || $this->input('birth_condition') === 'kuning' || $this->input('birth_condition') === 'kejang'),
                'integer',
                'min:0'
            ],
            'postbirth_condition_age' => [
                'nullable',
                Rule::requiredIf($this->input('postbirth_condition') === 'biru' || $this->input('birth_condition') === 'kuning' || $this->input('birth_condition') === 'kejang'),
                'integer',
                'min:0'
            ],
            'has_ever_fallen' => ['required', 'boolean'],
            'injured_body_part' => [
                'nullable',
                Rule::requiredIf($this->input('has_ever_fallen') == true),
                'string',
                'max:100'
            ],
            'age_at_fall' => [
                'nullable',
                Rule::requiredIf($this->input('has_ever_fallen') == true),
                'integer',
                'min:0'
            ],
            'other_postbirth_complications' => ['nullable', 'string'],
            'head_lift_age' => ['nullable', 'integer', 'min:0'],
            'prone_age' => ['nullable', 'integer', 'min:0'],
            'roll_over_age' => ['nullable', 'integer', 'min:0'],
            'sitting_age' => ['nullable', 'integer', 'min:0'],
            'crawling_age' => ['nullable', 'integer', 'min:0'],
            'climbing_age' => ['nullable', 'integer', 'min:0'],
            'standing_age' => ['nullable', 'integer', 'min:0'],
            'walking_age' => ['nullable', 'integer', 'min:0'],
            'complete_immunization' => ['required', 'boolean'],
            'uncompleted_immunization_detail' => [
                'nullable',
                Rule::requiredIf($this->input('complete_immunization') == false),
                'string'
            ],
            'exclusive_breastfeeding' => ['required', 'boolean'],
            'exclusive_breastfeeding_until_age' => [
                'nullable',
                Rule::requiredIf($this->input('exclusive_breastfeeding') == true),
                'integer',
                'min:0'
            ],
            'rice_intake_age' => ['nullable', 'integer', 'min:0'],

            'allergies_age' => ['nullable', 'integer', 'min:0'],
            'fever_age' => ['nullable', 'integer', 'min:0'],
            'ear_infections_age' => ['nullable', 'integer', 'min:0'],
            'headaches_age' => ['nullable', 'integer', 'min:0'],
            'mastoiditis_age' => ['nullable', 'integer', 'min:0'],
            'sinusitis_age' => ['nullable', 'integer', 'min:0'],
            'asthma_age' => ['nullable', 'integer', 'min:0'],
            'seizures_age' => ['nullable', 'integer', 'min:0'],
            'encephalitis_age' => ['nullable', 'integer', 'min:0'],
            'high_fever_age' => ['nullable', 'integer', 'min:0'],
            'meningitis_age' => ['nullable', 'integer', 'min:0'],
            'tonsillitis_age' => ['nullable', 'integer', 'min:0'],
            'chickenpox_age' => ['nullable', 'integer', 'min:0'],
            'dizziness_age' => ['nullable', 'integer', 'min:0'],
            'measles_or_rubella_age' => ['nullable', 'integer', 'min:0'],
            'influenza_age' => ['nullable', 'integer', 'min:0'],
            'pneumonia_age' => ['nullable', 'integer', 'min:0'],
            'others' => ['nullable', 'array'],
            'others.*.condition' => ['required_with:others', 'string'],
            'others.*.age' => ['required_with:others', 'integer', 'min:0'],
            'family_similar_conditions_detail' => ['required', 'string'],
            'family_mental_disorders' => ['required', 'string'],
            'child_surgeries_detail' => ['required', 'string'],
            'special_medical_conditions' => ['required', 'string'],
            'other_medications_detail' => ['required', 'string'],
            'negative_reactions_detail' => ['nullable', 'string'],
            'hospitalization_history' => ['required', 'string'],

            'currently_in_school' => ['required', 'boolean'],
            'school_location' => [
                'nullable',
                Rule::requiredIf($this->input('currently_in_school') == true),
                'string',
                'max:150'
            ],
            'school_class' => [
                'nullable',
                Rule::requiredIf($this->input('currently_in_school') == true),
                'integer'
            ],
            'long_absence_from_school' => ['required', 'boolean'],
            'long_absence_reason' => [
                'nullable',
                Rule::requiredIf($this->input('long_absence_from_school') == true),
                'string'
            ],
            'academic_and_socialization_detail' => ['required', 'string'],
            'special_treatment_detail' => ['required', 'string'],
            'learning_support_program' => ['required', 'boolean'],
            'learning_support_detail' => [
                'nullable',
                Rule::requiredIf($this->input('learning_support_program') == true),
                'string'
            ],
        ];
    }

    private function getPhysioRules(): array
    {
        return [
            'complaint' => ['required', 'string'],
            'medical_history' => ['required', 'string'],
        ];
    }

    private function getOccupationalRules(): array
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

    private function getSpeechRules(): array
    {
        return [
            'speech_problem_description' => ['required', 'string'],
            'communication_method' => ['required', 'string'],
            'language_first_known_and_who' => ['required', 'string'],
            'main_cause' => ['required', 'string'],
            'child_awareness' => ['required', 'boolean'],
            'child_awareness_detail' => ['nullable', 'string'],
            'previous_speech_therapy' => ['required', 'boolean'],
            'previous_speech_therapy_detail' => ['nullable', 'array'],
            'previous_speech_therapy_detail.*.who' => ['nullable', 'string'],
            'previous_speech_therapy_detail.*.when' => ['nullable', 'string'],
            'previous_speech_therapy_detail.*.summary' => ['nullable', 'string'],
            'other_specialist' => ['required', 'boolean'],
            'other_specialist_detail' => ['nullable', 'array'],
            'other_specialist_detail.*.result' => ['nullable', 'string'],
            'other_specialist_detail.*.when' => ['nullable', 'string'],
            'other_specialist_detail.*.summary' => ['nullable', 'string'],
            'family_communication_disorders' => ['required', 'boolean'],
            'family_communication_disorders_detail' => ['nullable', 'string'],
            'age_child_can_express_one_word' => ['nullable', 'integer'],
            'age_child_can_express_two_words' => ['nullable', 'integer'],
            'age_child_can_express_three_plus_words' => ['nullable', 'integer'],
            'age_child_can_express_sentences' => ['nullable', 'integer'],
            'age_child_can_tell_stories' => ['nullable', 'integer'],
            'feeding_difficulty' => ['required', 'string'],
            'sound_response_description' => ['required', 'string'],
        ];
    }

    private function getPedagogicalRules(): array
    {
        return [
            'iq_measurement' => ['required', 'boolean'],
            'iq_score' => ['nullable', Rule::requiredIf($this->input('iq_measurement') == true), 'integer'],
            'extra_academic_class' => ['required', 'boolean'],
            'special_teacher' => ['required', 'boolean'],
            'curriculum_modification' => ['required', 'boolean'],
            'seating_position_in_class' => ['nullable', 'string', 'max:100'],
            'child_hobbies' => ['nullable', 'string', 'max:100'],
            'non_academic_activity_detail' => ['nullable', 'string'],
            'non_academic_activity_location' => ['nullable', 'string'],
            'non_academic_activity_time' => ['nullable', 'string', 'max:100'],
            'learning_focus' => ['nullable', 'string', 'max:100'],
            'focus_duration' => ['nullable', 'string', 'max:50'],
            'focus_objects' => ['nullable', 'string'],
            'daily_home_study' => ['nullable', 'string', 'max:100'],
            'home_study_time' => ['nullable', 'string', 'max:100'],
            'home_study_companion' => ['nullable', 'string', 'max:150'],
            'study_environment_condition' => ['nullable', 'string', 'max:100'],
            'favorite_subject' => ['nullable', 'string', 'max:100'],
            'least_favorite_subject' => ['nullable', 'string', 'max:100'],

            // (pedagogical_visual_impairment_aspects)
            'has_visual_impairment' => ['required', 'boolean'],
            'wearing_glasses' => ['required', 'boolean'],
            'comfortable_reading_while_sitting' => ['required', 'boolean'],
            'comfortable_reading_while_lying_down' => ['required', 'boolean'],
            'daily_gadget_use' => ['required', 'boolean'],
            'gadget_exploration_duration' => ['required', 'string', 'max:100'],

            // (pedagogical_auditory_impairment_aspects)
            'has_auditory_impairment' => ['required', 'boolean'],
            'using_hearing_aid' => ['required', 'boolean'],
            'immediate_response_when_called' => ['required', 'boolean'],
            'prefers_listening_music_or_singing' => ['required', 'boolean'],
            'prefers_quiet_environment_when_studying' => ['required', 'boolean'],
            'responding_to_dislike_by_covering_ears' => ['required', 'boolean'],
            'often_uses_headset' => ['required', 'boolean'],

            // (pedagogical_motor_impairment_aspects)
            'has_motor_impairment' => ['required', 'boolean'],
            'motor_impairment_type' => ['nullable', Rule::requiredIf($this->input('has_motor_impairment') == true), 'string', Rule::in(['Motorik Halus', 'Motorik Kasar'])],
            'motor_impairment_form' => ['nullable', Rule::requiredIf($this->input('has_motor_impairment') == true), 'string'],
            'has_independent_mobility_difficulty' => ['required', 'boolean'],
            'has_body_part_weakness' => ['required', 'boolean'],

            // (pedagogical_cognitive_impairment_aspects)
            'has_cognitive_impairment' => ['required', 'boolean'],
            'needs_explanation_managing_information' => ['required', 'boolean'],
            'responsive_to_sudden_events' => ['required', 'boolean'],
            'preferred_activities' => ['required', 'string', 'max:100'],
            'interested_in_learning_new_info' => ['required', 'boolean'],

            // (pedagogical_behavioral_impairment_aspects)
            'has_behavioral_problems' => ['required', 'boolean'],
            'easily_befriends_peers' => ['required', 'boolean'],
            'quick_mood_swings' => ['required', 'boolean'],
            'likes_violence_expressing_emotions' => ['required', 'boolean'],
            'tends_to_be_alone' => ['required', 'boolean'],
            'reluctant_to_greet_smile' => ['required', 'boolean'],

            //(pedagogical_social_communication_aspects)
            'child_attitude_when_meeting_new_people' => ['nullable', 'string'],
            'child_attitude_when_meeting_friends' => ['nullable', 'string'],
            'child_often_or_never_initiate_conversations' => ['nullable', 'string'],
            'active_when_speak_to_family' => ['nullable', 'string'],
            'attitude_in_uncomfortable_situations' => ['nullable', 'string'],
            'can_share_toys_food_when_playing' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Tipe assessment wajib diisi.',
            'type.in' => 'Tipe assessment tidak valid.',
        ];
    }
}
