<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccupationalSensoryModalityTest extends Model
{
    use HasFactory;

    protected $table = 'occupational_sensory_modality_tests';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'gust_thinks_all_food_tastes_same',
        'gust_chews_non_food_items',
        'gust_selective_food_taste',
        'gust_dislikes_certain_food_textures',
        'gust_explores_with_smell',
        'gust_can_distinguish_smells',
        'gust_negative_reaction_to_smells',
        'gust_ignores_unpleasant_smells',
        'vis_prefers_darkness',
        'vis_points_at_objects_detailed',
        'vis_enjoys_variety_of_objects',
        'vis_often_spining',
        'vis_wears_glasses',
        'vis_difficulty_following_objects',
        'vis_difficulty_eye_contact',
        'vis_turns_head_side_to_side',
        'vis_reaches_too_far',
        'tact_avoids_dirty_play',
        'tact_dislikes_face_wiping',
        'tact_bothered_by_fabric_textures',
        'tact_dislikes_being_touched',
        'tact_dislikes_suddeny_touch',
        'tact_dislikes_hugs',
        'tact_prefers_touching_over_being_touched',
        'tact_avoids_using_hands',
        'tact_deliberately_hurts_head',
        'tact_bites_or_hurts_self_others',
        'tact_explores_objects_with_mouth',
        'tact_feels_more_pain',
        'tact_hurts_other_children',
        'tact_dislikes_hair_washing',
        'tact_dislikes_nail_cutting',
        'prop_holds_hands_in_odd_position',
        'prop_holds_body_in_odd_position',
        'prop_good_at_imitating_small_things',
        'prop_makes_fast_repetitive_movements',
        'prop_difficulty_changing_positions',
        'swinging_while_sitting',
        'jumps_a_lot',
        'enjoys_being_thrown_in_air',
        'has_good_balance',
        'fearful_of_spaces',
        'likes_carousel',
        'spins_more_than_other_children',
        'gets_car_sick',
        'enjoys_swinging',
        'not_afraid_of_falling',
        'restless_in_long_car_rides',
    ];

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
