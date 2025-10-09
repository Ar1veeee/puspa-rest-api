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
        Schema::create('child_health_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->integer('allergies_age')->nullable();
            $table->integer('fever_age')->nullable();
            $table->integer('ear_infections_age')->nullable();
            $table->integer('headaches_age')->nullable();
            $table->integer('mastoiditis_age')->nullable();
            $table->integer('sinusitis_age')->nullable();
            $table->integer('asthma_age')->nullable();
            $table->integer('seizures_age')->nullable();
            $table->integer('encephalitis_age')->nullable();
            $table->integer('high_fever_age')->nullable();
            $table->integer('meningitis_age')->nullable();
            $table->integer('tonsillitis_age')->nullable();
            $table->integer('chickenpox_age')->nullable();
            $table->integer('dizziness_age')->nullable();
            $table->integer('measles_or_rubella_age')->nullable();
            $table->integer('influenza_age')->nullable();
            $table->integer('pneumonia_age')->nullable();
            $table->json('other_disease')->nullable();
            $table->text('family_similar_conditions_detail');
            $table->text('family_mental_disorders');
            $table->text('child_surgeries_detail');
            $table->text('special_medical_conditions');
            $table->text('other_medications_detail');
            $table->text('negative_reactions_detail');
            $table->text('hospitalization_history');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_health_histories');
    }
};
