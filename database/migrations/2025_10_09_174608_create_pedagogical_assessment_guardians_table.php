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
        Schema::create('pedagogical_assessment_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained('assessments')->onDelete('cascade');
            $table->foreignId('academic_aspect_id')->nullable();
            $table->foreign('academic_aspect_id', 'fk_peda_academic_aspect_id')
                ->references('id')
                ->on('pedagogical_academic_aspects')
                ->onDelete('set null');
            $table->foreignId('visual_impairment_aspect_id')->nullable();
            $table->foreign('visual_impairment_aspect_id', 'fk_peda_visual_id')
                ->references('id')
                ->on('pedagogical_visual_impairment_aspects')
                ->onDelete('set null');
            $table->foreignId('auditory_impairment_aspect_id')->nullable();
            $table->foreign('auditory_impairment_aspect_id', 'fk_peda_auditory_id')
                ->references('id')
                ->on('pedagogical_auditory_impairment_aspects')
                ->onDelete('set null');
            $table->foreignId('motor_impairment_aspects_id')->nullable();
            $table->foreign('motor_impairment_aspects_id', 'fk_peda_motor_id')
                ->references('id')
                ->on('pedagogical_motor_impairment_aspects')
                ->onDelete('set null');
            $table->foreignId('behavioral_impairment_aspect_id')->nullable();
            $table->foreign('behavioral_impairment_aspect_id', 'fk_peda_behavioral_id')
                ->references('id')
                ->on('pedagogical_behavioral_impairment_aspects')
                ->onDelete('set null');
            $table->foreignId('social_communication_aspect_id')->nullable();
            $table->foreign('social_communication_aspect_id', 'fk_peda_social_comm_id')
                ->references('id')
                ->on('pedagogical_social_communication_aspects')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_assessment_guardians');
    }
};
