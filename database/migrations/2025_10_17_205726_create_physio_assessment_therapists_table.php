<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('physio_assessment_therapists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained('assessments')->onDelete('cascade');
            $table->foreignUlid('therapist_id')->constrained('therapists')->onDelete('cascade');

            $table->foreignId('general_examination_id')->nullable()
                ->constrained('physio_general_examinations', 'id', 'fk_physio_general_exam')->onDelete('set null');

            $table->foreignId('system_anamnesis_id')->nullable();
            $table->foreign('system_anamnesis_id', 'fk_physio_sys_anam')
                ->references('id')->on('physio_system_anamnesis')->onDelete('set null');

            $table->foreignId('sensory_examination_id')->nullable()
                ->constrained('physio_sensory_examinations', 'id', 'fk_physio_sensory')->onDelete('set null');

            $table->foreignId('reflex_examination_id')->nullable()
                ->constrained('physio_reflex_examinations', 'id', 'fk_physio_reflex')->onDelete('set null');

            $table->foreignId('muscle_strength_examination_id')->nullable()
                ->constrained('physio_muscle_strength_examinations', 'id', 'fk_physio_muscle_strength')->onDelete('set null');

            $table->foreignId('spasticity_examination_id')->nullable()
                ->constrained('physio_spasticity_examinations', 'id', 'fk_physio_spasticity')->onDelete('set null');

            $table->foreignId('joint_laxity_test_id')->nullable()
                ->constrained('physio_joint_laxity_tests', 'id', 'fk_physio_joint_lax')->onDelete('set null');

            $table->foreignId('gross_motor_examination_id')->nullable()
                ->constrained('physio_gross_motor_examinations', 'id', 'fk_physio_gross_motor')->onDelete('set null');

            $table->foreignId('muscle_palpation_id')->nullable()
                ->constrained('physio_muscle_palpations', 'id', 'fk_physio_palp')->onDelete('set null');

            $table->foreignId('spasticity_type_id')->nullable()
                ->constrained('physio_spasticity_types', 'id', 'fk_physio_spas_type')->onDelete('set null');

            $table->foreignId('play_function_test_id')->nullable()
                ->constrained('physio_play_function_tests', 'id', 'fk_physio_play_func')->onDelete('set null');

            $table->foreignId('physiotherapy_diagnosis_id')->nullable()
                ->constrained('physio_physiotherapy_diagnoses', 'id', 'fk_physio_diag')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physio_assessment_therapists');
    }
};
