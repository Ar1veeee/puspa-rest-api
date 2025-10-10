<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupationalGuardianDataAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'easily_disturbed_by_sound' => $this->auditoryCommunication?->easily_disturbed_by_sound,
            'cannot_follow_simple_instructions' => $this->auditoryCommunication?->cannot_follow_simple_instructions,
            'confused_by_words' => $this->auditoryCommunication?->confused_by_words,
            'only_uses_body_language' => $this->auditoryCommunication?->only_uses_body_language,
            'likes_to_sing' => $this->auditoryCommunication?->likes_to_sing,
            'speech_sound_difficulty' => $this->auditoryCommunication?->speech_sound_difficulty,
            'attentive_but_confused' => $this->auditoryCommunication?->attentive_but_confused,
            'hesitant_to_speak' => $this->auditoryCommunication?->hesitant_to_speak,
            'understands_body_language_facial_expressions' => $this->auditoryCommunication?->understands_body_language_facial_expressions,

            'gust_thinks_all_food_tastes_same' => $this->sensoryModalityTest?->gust_thinks_all_food_tastes_same,
            'gust_chews_non_food_items' => $this->sensoryModalityTest?->gust_chews_non_food_items,
            'gust_selective_food_taste' => $this->sensoryModalityTest?->gust_selective_food_taste,
            'gust_dislikes_certain_food_textures' => $this->sensoryModalityTest?->gust_dislikes_certain_food_textures,
            'gust_explores_with_smell' => $this->sensoryModalityTest?->gust_explores_with_smell,
            'gust_can_distinguish_smells' => $this->sensoryModalityTest?->gust_can_distinguish_smells,
            'gust_negative_reaction_to_smells' => $this->sensoryModalityTest?->gust_negative_reaction_to_smells,
            'gust_ignores_unpleasant_smells' => $this->sensoryModalityTest?->gust_ignores_unpleasant_smells,
            'vis_prefers_darkness' => $this->sensoryModalityTest?->vis_prefers_darkness,
            'vis_points_at_objects_detailed' => $this->sensoryModalityTest?->vis_points_at_objects_detailed,
            'vis_enjoys_variety_of_objects' => $this->sensoryModalityTest?->vis_enjoys_variety_of_objects,
            'vis_often_spining' => $this->sensoryModalityTest?->vis_often_spining,
            'vis_wears_glasses' => $this->sensoryModalityTest?->vis_wears_glasses,
            'vis_difficulty_following_objects' => $this->sensoryModalityTest?->vis_difficulty_following_objects,
            'vis_difficulty_eye_contact' => $this->sensoryModalityTest?->vis_difficulty_eye_contact,
            'vis_turns_head_side_to_side' => $this->sensoryModalityTest?->vis_turns_head_side_to_side,
            'vis_reaches_too_far' => $this->sensoryModalityTest?->vis_reaches_too_far,
            'tact_avoids_dirty_play' => $this->sensoryModalityTest?->tact_avoids_dirty_play,
            'tact_dislikes_face_wiping' => $this->sensoryModalityTest?->tact_dislikes_face_wiping,
            'tact_bothered_by_fabric_textures' => $this->sensoryModalityTest?->tact_bothered_by_fabric_textures,
            'tact_dislikes_being_touched' => $this->sensoryModalityTest?->tact_dislikes_being_touched,
            'tact_dislikes_suddeny_touch' => $this->sensoryModalityTest?->tact_dislikes_suddeny_touch,
            'tact_dislikes_hugs' => $this->sensoryModalityTest?->tact_dislikes_hugs,
            'tact_prefers_touching_over_being_touched' => $this->sensoryModalityTest?->tact_prefers_touching_over_being_touched,
            'tact_avoids_using_hands' => $this->sensoryModalityTest?->tact_avoids_using_hands,
            'tact_deliberately_hurts_head' => $this->sensoryModalityTest?->tact_deliberately_hurts_head,
            'tact_bites_or_hurts_self_others' => $this->sensoryModalityTest?->tact_bites_or_hurts_self_others,
            'tact_explores_objects_with_mouth' => $this->sensoryModalityTest?->tact_explores_objects_with_mouth,
            'tact_feels_more_pain' => $this->sensoryModalityTest?->tact_feels_more_pain,
            'tact_hurts_other_children' => $this->sensoryModalityTest?->tact_hurts_other_children,
            'tact_dislikes_hair_washing' => $this->sensoryModalityTest?->tact_dislikes_hair_washing,
            'tact_dislikes_nail_cutting' => $this->sensoryModalityTest?->tact_dislikes_nail_cutting,
            'prop_holds_hands_in_odd_position' => $this->sensoryModalityTest?->prop_holds_hands_in_odd_position,
            'prop_holds_body_in_odd_position' => $this->sensoryModalityTest?->prop_holds_body_in_odd_position,
            'prop_good_at_imitating_small_things' => $this->sensoryModalityTest?->prop_good_at_imitating_small_things,
            'prop_makes_fast_repetitive_movements' => $this->sensoryModalityTest?->prop_makes_fast_repetitive_movements,
            'prop_difficulty_changing_positions' => $this->sensoryModalityTest?->prop_difficulty_changing_positions,
            'swinging_while_sitting' => $this->sensoryModalityTest?->swinging_while_sitting,
            'jumps_a_lot' => $this->sensoryModalityTest?->jumps_a_lot,
            'enjoys_being_thrown_in_air' => $this->sensoryModalityTest?->enjoys_being_thrown_in_air,
            'has_good_balance' => $this->sensoryModalityTest?->has_good_balance,
            'fearful_of_spaces' => $this->sensoryModalityTest?->fearful_of_spaces,
            'likes_carousel' => $this->sensoryModalityTest?->likes_carousel,
            'spins_more_than_other_children' => $this->sensoryModalityTest?->spins_more_than_other_children,
            'gets_car_sick' => $this->sensoryModalityTest?->gets_car_sick,
            'enjoys_swinging' => $this->sensoryModalityTest?->enjoys_swinging,
            'not_afraid_of_falling' => $this->sensoryModalityTest?->not_afraid_of_falling,
            'restless_in_long_car_rides' => $this->sensoryModalityTest?->restless_in_long_car_rides,

            'disturbed_by_physical_contact_with_others' => $this->sensoryProcessingScreening?->disturbed_by_physical_contact_with_others,
            'dislikes_nail_trimming' => $this->sensoryProcessingScreening?->dislikes_nail_trimming,
            'fear_in_balance_climbing_games' => $this->sensoryProcessingScreening?->fear_in_balance_climbing_games,
            'excessive_spinning_swinging_games' => $this->sensoryProcessingScreening?->excessive_spinning_swinging_games,
            'passive_when_at_home' => $this->sensoryProcessingScreening?->passive_when_at_home,
            'likes_to_be_hugged_and_bought' => $this->sensoryProcessingScreening?->likes_to_be_hugged_and_bought,
            'puts_fingers_toys_in_mouth' => $this->sensoryProcessingScreening?->puts_fingers_toys_in_mouth,
            'dislikes_certain_food_textures' => $this->sensoryProcessingScreening?->dislikes_certain_food_textures,
            'disturbed_by_loud_voices' => $this->sensoryProcessingScreening?->disturbed_by_loud_voices,
            'likes_to_touch_objects' => $this->sensoryProcessingScreening?->likes_to_touch_objects,
            'disturbed_by_certain_textures' => $this->sensoryProcessingScreening?->disturbed_by_certain_textures,
            'shows_extreme_dislike_to_something' => $this->sensoryProcessingScreening?->shows_extreme_dislike_to_something,

            'difficulty_regulating_emotions' => $this->adlMotorSkill?->difficulty_regulating_emotions,
            'difficulty_dressing' => $this->adlMotorSkill?->difficulty_dressing,
            'difficulty_wearing_shoes_socks' => $this->adlMotorSkill?->difficulty_wearing_shoes_socks,
            'difficulty_tying_shoelaces' => $this->adlMotorSkill?->difficulty_tying_shoelaces,
            'difficulty_buttoning' => $this->adlMotorSkill?->difficulty_buttoning,
            'difficulty_self_cleaning' => $this->adlMotorSkill?->difficulty_self_cleaning,
            'difficulty_brushing_teeth' => $this->adlMotorSkill?->difficulty_brushing_teeth,
            'difficulty_combing_hair' => $this->adlMotorSkill?->difficulty_combing_hair,
            'difficulty_standing_on_one_leg' => $this->adlMotorSkill?->difficulty_standing_on_one_leg,
            'difficulty_jumping_in_place' => $this->adlMotorSkill?->difficulty_jumping_in_place,
            'difficulty_skipping_rope' => $this->adlMotorSkill?->difficulty_skipping_rope,
            'difficulty_riding_bike' => $this->adlMotorSkill?->difficulty_riding_bike,
            'difficulty_using_playground_equipment' => $this->adlMotorSkill?->difficulty_using_playground_equipment,
            'difficulty_climbing_stairs' => $this->adlMotorSkill?->difficulty_climbing_stairs,

            'is_quiet' => $this->behaviorSocial?->is_quiet,
            'is_hyperactive' => $this->behaviorSocial?->is_hyperactive,
            'difficulty_managing_frustration' => $this->behaviorSocial?->difficulty_managing_frustration,
            'is_impulsive' => $this->behaviorSocial?->is_impulsive,
            'attention_seeking' => $this->behaviorSocial?->attention_seeking,
            'withdrawn' => $this->behaviorSocial?->withdrawn,
            'is_curious' => $this->behaviorSocial?->is_curious,
            'is_aggressive' => $this->behaviorSocial?->is_aggressive,
            'is_shy' => $this->behaviorSocial?->is_shy,
            'behavior_problems_at_home' => $this->behaviorSocial?->behavior_problems_at_home,
            'behavior_problems_at_school' => $this->behaviorSocial?->behavior_problems_at_school,
            'is_emotional' => $this->behaviorSocial?->is_emotional,
            'unusual_fears' => $this->behaviorSocial?->unusual_fears,
            'frequent_tantrums' => $this->behaviorSocial?->frequent_tantrums,
            'good_relationship_with_siblings' => $this->behaviorSocial?->good_relationship_with_siblings,
            'makes_friends_easily' => $this->behaviorSocial?->makes_friends_easily,
            'understands_game_rules' => $this->behaviorSocial?->understands_game_rules,
            'understands_jokes' => $this->behaviorSocial?->understands_jokes,
            'is_rigid' => $this->behaviorSocial?->is_rigid,
            'plays_with_other_children' => $this->behaviorSocial?->plays_with_other_children,

            'easy_to_surrender' => $this->behaviorScale?->easy_to_surrender,
            'distracted_by_attention' => $this->behaviorScale?->distracted_by_attention,
            'difficulty_sitting_quietly_5min' => $this->behaviorScale?->difficulty_sitting_quietly_5min,
            'cannot_concentrate_20min' => $this->behaviorScale?->cannot_concentrate_20min,
            'often_tries_to_forget_personal_belongings' => $this->behaviorScale?->often_tries_to_forget_personal_belongings,
            'responds_without_clear_reason' => $this->behaviorScale?->responds_without_clear_reason,
            'refuses_to_follow_orders_even_simple' => $this->behaviorScale?->refuses_to_follow_orders_even_simple,
            'not_patient_waiting_turn' => $this->behaviorScale?->not_patient_waiting_turn,
        ];

        return $response;
    }
}
