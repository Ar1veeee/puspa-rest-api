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
        Schema::create('occupational_assessment_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained('assessments')->onDelete('cascade');
            $table->foreignId('auditory_communication_id')->nullable();
            $table->foreign('auditory_communication_id', 'fk_occ_auditory_comm_id')
                ->references('id')
                ->on('occupational_auditory_communications')
                ->onDelete('set null');
            $table->foreignId('sensory_modality_id')->nullable();
            $table->foreign('sensory_modality_id', 'fk_occ_sensory_modality_id')
                ->references('id')
                ->on('occupational_sensory_modality_tests')
                ->onDelete('set null');
            $table->foreignId('sensory_processing_screening_id')->nullable();
            $table->foreign('sensory_processing_screening_id', 'fk_occ_sensory_proc_id')
                ->references('id')
                ->on('occupational_sensory_processing_screenings')
                ->onDelete('set null');
            $table->foreignId('adl_motor_skill_id')->nullable();
            $table->foreign('adl_motor_skill_id', 'fk_occ_adl_motor_skill_id')
                ->references('id')
                ->on('occupational_adl_motor_skills')
                ->onDelete('set null');
            $table->foreignId('behavior_social_id')->nullable();
            $table->foreign('behavior_social_id', 'fk_occ_behavior_social_id')
                ->references('id')
                ->on('occupational_behavior_socials')
                ->onDelete('set null');
            $table->foreignId('behavior_scale_id')->nullable();
            $table->foreign('behavior_scale_id', 'fk_occ_behavior_scale_id')
                ->references('id')
                ->on('occupational_behavior_scales')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_assessment_guardians');
    }
};
