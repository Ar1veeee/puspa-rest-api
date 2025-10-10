<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('occupational_sensory_modality_tests', function (Blueprint $table) {
            $table->id();
            $options = ['ya', 'tidak', 'kadang-kadang'];

            // GUSTATORI/OLFAKTORI
            $table->enum('gust_thinks_all_food_tastes_same', $options);
            $table->enum('gust_chews_non_food_items', $options);
            $table->enum('gust_selective_food_taste', $options);
            $table->enum('gust_dislikes_certain_food_textures', $options);
            $table->enum('gust_explores_with_smell', $options);
            $table->enum('gust_can_distinguish_smells', $options);
            $table->enum('gust_negative_reaction_to_smells', $options);
            $table->enum('gust_ignores_unpleasant_smells', $options);

            // VISUAL
            $table->enum('vis_prefers_darkness', $options);
            $table->enum('vis_points_at_objects_detailed', $options);
            $table->enum('vis_enjoys_variety_of_objects', $options);
            $table->enum('vis_often_spining', $options);
            $table->enum('vis_wears_glasses', $options);
            $table->enum('vis_difficulty_following_objects', $options);
            $table->enum('vis_difficulty_eye_contact', $options);
            $table->enum('vis_turns_head_side_to_side', $options);
            $table->enum('vis_reaches_too_far', $options);

            // TAKTIL
            $table->enum('tact_avoids_dirty_play', $options);
            $table->enum('tact_dislikes_face_wiping', $options);
            $table->enum('tact_bothered_by_fabric_textures', $options);
            $table->enum('tact_dislikes_being_touched', $options);
            $table->enum('tact_dislikes_suddeny_touch', $options);
            $table->enum('tact_dislikes_hugs', $options);
            $table->enum('tact_prefers_touching_over_being_touched', $options);
            $table->enum('tact_avoids_using_hands', $options);
            $table->enum('tact_deliberately_hurts_head', $options);
            $table->enum('tact_bites_or_hurts_self_others', $options);
            $table->enum('tact_explores_objects_with_mouth', $options);
            $table->enum('tact_feels_more_pain', $options);
            $table->enum('tact_hurts_other_children', $options);
            $table->enum('tact_dislikes_hair_washing', $options);
            $table->enum('tact_dislikes_nail_cutting', $options);

            // PROPIOSEPTIF
            $table->enum('prop_holds_hands_in_odd_position', $options);
            $table->enum('prop_holds_body_in_odd_position', $options);
            $table->enum('prop_good_at_imitating_small_things', $options);
            $table->enum('prop_makes_fast_repetitive_movements', $options);
            $table->enum('prop_difficulty_changing_positions', $options);

            // VESTIBULAR
            $table->enum('swinging_while_sitting', $options);
            $table->enum('jumps_a_lot', $options);
            $table->enum('enjoys_being_thrown_in_air', $options);
            $table->enum('has_good_balance', $options);
            $table->enum('fearful_of_spaces', $options);
            $table->enum('likes_carousel', $options);
            $table->enum('spins_more_than_other_children', $options);
            $table->enum('gets_car_sick', $options);
            $table->enum('enjoys_swinging', $options);
            $table->enum('not_afraid_of_falling', $options);
            $table->enum('restless_in_long_car_rides', $options);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_sensory_modality_tests');
    }
};
