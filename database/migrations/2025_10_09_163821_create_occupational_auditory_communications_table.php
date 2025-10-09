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
        Schema::create('occupational_auditory_communications', function (Blueprint $table) {
            $table->id();
            $table->boolean('easily_disturbed_by_sound');
            $table->boolean('cannot_follow_simple_instructions');
            $table->boolean('confused_by_words');
            $table->boolean('only_uses_body_language');
            $table->boolean('likes_to_sing');
            $table->boolean('speech_sound_difficulty');
            $table->boolean('attentive_but_confused');
            $table->boolean('hesitant_to_speak');
            $table->boolean('understands_body_language_facial_expressions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_auditory_communications');
    }
};
