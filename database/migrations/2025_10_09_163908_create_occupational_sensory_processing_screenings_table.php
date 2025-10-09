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
        Schema::create('occupational_sensory_processing_screenings', function (Blueprint $table) {
            $table->id();
            $table->boolean('disturbed_by_physical_contact_with_others');
            $table->boolean('dislikes_nail_trimming');
            $table->boolean('fear_in_balance_climbing_games');
            $table->boolean('excessive_spinning_swinging_games');
            $table->boolean('passive_when_at_home');
            $table->boolean('likes_to_be_hugged_and_bought');
            $table->boolean('puts_fingers_toys_in_mouth');
            $table->boolean('dislikes_certain_food_textures');
            $table->boolean('disturbed_by_loud_voices');
            $table->boolean('likes_to_touch_objects');
            $table->boolean('disturbed_by_certain_textures');
            $table->boolean('shows_extreme_dislike_to_something');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_sensory_processing_screenings');
    }
};
