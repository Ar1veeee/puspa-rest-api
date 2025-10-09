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
        Schema::create('pedagogical_academic_aspects', function (Blueprint $table) {
            $table->id();
            $table->boolean('iq_measurement');
            $table->integer('iq_score')->nullable();
            $table->boolean('extra_academic_class');
            $table->boolean('special_teacher');
            $table->boolean('curriculum_modification');
            $table->string('seating_position_in_class', 100)->nullable();
            $table->string('child_hobbies', 100)->nullable();
            $table->text('non_academic_activity_detail')->nullable();
            $table->text('non_academic_activity_location')->nullable();
            $table->string('non_academic_activity_time', 100)->nullable();
            $table->string('learning_focus', 100)->nullable();
            $table->string('focus_duration', 50)->nullable();
            $table->text('focus_objects')->nullable();
            $table->string('daily_home_study', 100)->nullable();
            $table->string('home_study_time', 100)->nullable();
            $table->string('home_study_companion', 150)->nullable();
            $table->string('study_environment_condition', 100)->nullable();
            $table->string('favorite_subject', 100)->nullable();
            $table->string('least_favorite_subject', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_academic_aspects');
    }
};
