<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occu_assessment_therapists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained('assessments')->onDelete('cascade');
            $table->foreignId('bodily_self_sense_id')->nullable()->constrained('occu_bodily_self_senses')->onDelete('set null');
            $table->foreignId('balance_coordination_id')->nullable();
            $table->foreign('balance_coordination_id', 'fk_occu_balance_id')
                ->references('id')
                ->on('occu_balance_coordinations')
                ->onDelete('set null');
            $table->foreignId('concentration_problem_solving_id')->nullable();
            $table->foreign('concentration_problem_solving_id', 'fk_occu_concentration_id')
                ->references('id')
                ->on('occu_concentration_problem_solvings')
                ->onDelete('set null');
            $table->foreignId('concept_knowledge_id')->nullable()->constrained('occu_concept_knowledges')->onDelete('set null');
            $table->foreignId('motoric_planning_id')->nullable()->constrained('occu_motoric_plannings')->onDelete('set null');
            $table->text('note')->nullable();
            $table->text('assessment_result')->nullable();
            $table->text('therapy_recommendation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occu_assessment_therapists');
    }
};
