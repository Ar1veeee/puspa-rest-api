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
        Schema::create('occupational_adl_motor_skills', function (Blueprint $table) {
            $table->id();
            $table->boolean('difficulty_regulating_emotions');
            $table->boolean('difficulty_dressing');
            $table->boolean('difficulty_wearing_shoes_socks');
            $table->boolean('difficulty_tying_shoelaces');
            $table->boolean('difficulty_buttoning');
            $table->boolean('difficulty_self_cleaning');
            $table->boolean('difficulty_brushing_teeth');
            $table->boolean('difficulty_combing_hair');
            $table->boolean('difficulty_standing_on_one_leg');
            $table->boolean('difficulty_jumping_in_place');
            $table->boolean('difficulty_skipping_rope');
            $table->boolean('difficulty_riding_bike');
            $table->boolean('difficulty_using_playground_equipment');
            $table->boolean('difficulty_climbing_stairs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_adl_motor_skills');
    }
};
