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
        Schema::create('occupational_behavior_socials', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_quiet');
            $table->boolean('is_hyperactive');
            $table->boolean('difficulty_managing_frustration');
            $table->boolean('is_impulsive');
            $table->boolean('attention_seeking');
            $table->boolean('withdrawn');
            $table->boolean('is_curious');
            $table->boolean('is_aggressive');
            $table->boolean('is_shy');
            $table->boolean('behavior_problems_at_home');
            $table->boolean('behavior_problems_at_school');
            $table->boolean('is_emotional');
            $table->boolean('unusual_fears');
            $table->boolean('frequent_tantrums');
            $table->boolean('good_relationship_with_siblings');
            $table->boolean('makes_friends_easily');
            $table->boolean('understands_game_rules');
            $table->boolean('understands_jokes');
            $table->boolean('is_rigid');
            $table->enum('plays_with_other_children', ['lebih tua', 'lebih muda', 'seumuran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_behavior_socials');
    }
};
