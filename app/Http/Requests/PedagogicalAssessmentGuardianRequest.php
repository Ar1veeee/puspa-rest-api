<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PedagogicalAssessmentGuardianRequest extends FormRequest
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
        return [
            // (pedagogical_academic_aspects)
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
}
