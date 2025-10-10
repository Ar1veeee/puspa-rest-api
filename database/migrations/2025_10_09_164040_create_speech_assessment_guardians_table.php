<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('speech_assessment_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained('assessments')->onDelete('cascade');
            $table->text('speech_problem_description');
            $table->string('communication_method', 100);
            $table->text('language_first_known_and_who');
            $table->text('main_cause');
            $table->boolean('child_awareness');
            $table->text('child_awareness_detail')->nullable();
            $table->boolean('previous_speech_therapy');
            $table->json('previous_speech_therapy_detail')->nullable();
            $table->boolean('other_specialist');
            $table->json('other_specialist_detail')->nullable();
            $table->boolean('family_communication_disorders');
            $table->text('family_communication_disorders_detail')->nullable();
            $table->integer('age_child_can_express_one_word')->nullable();
            $table->integer('age_child_can_express_two_words')->nullable();
            $table->integer('age_child_can_express_three_plus_words')->nullable();
            $table->integer('age_child_can_express_sentences')->nullable();
            $table->integer('age_child_can_tell_stories')->nullable();
            $table->text('feeding_difficulty');
            $table->text('sound_response_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speech_assessment_guardians');
    }
};
