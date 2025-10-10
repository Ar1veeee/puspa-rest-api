<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedagogicalGuardianDataAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'iq_measurement' => $this->academicAspect?->iq_measurement,
            'iq_score' => $this->academicAspect?->iq_score,
            'extra_academic_class' => $this->academicAspect?->extra_academic_class,
            'special_teacher' => $this->academicAspect?->special_teacher,
            'curriculum_modification' => $this->academicAspect?->curriculum_modification,
            'seating_position_in_class' => $this->academicAspect?->seating_position_in_class,
            'child_hobbies' => $this->academicAspect?->child_hobbies,
            'non_academic_activity_detail' => $this->academicAspect?->non_academic_activity_detail,
            'non_academic_activity_location' => $this->academicAspect?->non_academic_activity_location,
            'non_academic_activity_time' => $this->academicAspect?->non_academic_activity_time,
            'learning_focus' => $this->academicAspect?->learning_focus,
            'focus_duration' => $this->academicAspect?->focus_duration,
            'focus_objects' => $this->academicAspect?->focus_objects,
            'daily_home_study' => $this->academicAspect?->daily_home_study,
            'home_study_time' => $this->academicAspect?->home_study_time,
            'home_study_companion' => $this->academicAspect?->home_study_companion,
            'study_environment_condition' => $this->academicAspect?->study_environment_condition,
            'favorite_subject' => $this->academicAspect?->favorite_subject,
            'least_favorite_subject' => $this->academicAspect?->least_favorite_subject,

            'has_visual_impairment' => $this->visualImpairmentAspect?->has_visual_impairment,
            'wearing_glasses' => $this->visualImpairmentAspect?->wearing_glasses,
            'comfortable_reading_while_sitting' => $this->visualImpairmentAspect?->comfortable_reading_while_sitting,
            'comfortable_reading_while_lying_down' => $this->visualImpairmentAspect?->comfortable_reading_while_lying_down,
            'daily_gadget_use' => $this->visualImpairmentAspect?->daily_gadget_use,
            'gadget_exploration_duration' => $this->visualImpairmentAspect?->gadget_exploration_duration,

            'has_auditory_impairment' => $this->auditoryImpairmentAspect?->has_auditory_impairment,
            'using_hearing_aid' => $this->auditoryImpairmentAspect?->using_hearing_aid,
            'immediate_response_when_called' => $this->auditoryImpairmentAspect?->immediate_response_when_called,
            'prefers_listening_music_or_singing' => $this->auditoryImpairmentAspect?->prefers_listening_music_or_singing,
            'prefers_quiet_environment_when_studying' => $this->auditoryImpairmentAspect?->prefers_quiet_environment_when_studying,
            'responding_to_dislike_by_covering_ears' => $this->auditoryImpairmentAspect?->responding_to_dislike_by_covering_ears,
            'often_uses_headset' => $this->auditoryImpairmentAspect?->often_uses_headset,

            'has_motor_impairment' => $this->motorImpairmentAspect?->has_motor_impairment,
            'motor_impairment_type' => $this->motorImpairmentAspect?->motor_impairment_type,
            'motor_impairment_form' => $this->motorImpairmentAspect?->motor_impairment_form,
            'has_independent_mobility_difficulty' => $this->motorImpairmentAspect?->has_independent_mobility_difficulty,
            'has_body_part_weakness' => $this->motorImpairmentAspect?->has_body_part_weakness,

            'has_cognitive_impairment' => $this->cognitiveImpairmentAspect?->has_cognitive_impairment,
            'needs_explanation_managing_information' => $this->cognitiveImpairmentAspect?->needs_explanation_managing_information,
            'responsive_to_sudden_events' => $this->cognitiveImpairmentAspect?->responsive_to_sudden_events,
            'preferred_activities' => $this->cognitiveImpairmentAspect?->preferred_activities,
            'interested_in_learning_new_info' => $this->cognitiveImpairmentAspect?->interested_in_learning_new_info,

            'has_behavioral_problems' => $this->behavioralImpairmentAspect?->has_behavioral_problems,
            'easily_befriends_peers' => $this->behavioralImpairmentAspect?->easily_befriends_peers,
            'quick_mood_swings' => $this->behavioralImpairmentAspect?->quick_mood_swings,
            'likes_violence_expressing_emotions' => $this->behavioralImpairmentAspect?->likes_violence_expressing_emotions,
            'tends_to_be_alone' => $this->behavioralImpairmentAspect?->tends_to_be_alone,
            'reluctant_to_greet_smile' => $this->behavioralImpairmentAspect?->reluctant_to_greet_smile,

            'child_attitude_when_meeting_new_people' => $this->socialCommunicationAspect?->child_attitude_when_meeting_new_people,
            'child_attitude_when_meeting_friends' => $this->socialCommunicationAspect?->child_attitude_when_meeting_friends,
            'child_often_or_never_initiate_conversations' => $this->socialCommunicationAspect?->child_often_or_never_initiate_conversations,
            'active_when_speak_to_family' => $this->socialCommunicationAspect?->active_when_speak_to_family,
            'attitude_in_uncomfortable_situations' => $this->socialCommunicationAspect?->attitude_in_uncomfortable_situations,
            'can_share_toys_food_when_playing' => $this->socialCommunicationAspect?->can_share_toys_food_when_playing,
        ];

        return $response;
    }
}
