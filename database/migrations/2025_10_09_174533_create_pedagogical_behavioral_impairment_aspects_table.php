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
        Schema::create('pedagogical_behavioral_impairment_aspects', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_behavioral_problems');
            $table->boolean('easily_befriends_peers');
            $table->boolean('quick_mood_swings');
            $table->boolean('likes_violence_expressing_emotions');
            $table->boolean('tends_to_be_alone');
            $table->boolean('reluctant_to_greet_smile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_behavioral_impairment_aspects');
    }
};
