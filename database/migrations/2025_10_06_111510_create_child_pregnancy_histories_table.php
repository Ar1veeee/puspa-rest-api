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
        Schema::create('child_pregnancy_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->boolean('pregnancy_desired');
            $table->boolean('routine_checkup');
            $table->integer('mother_age_at_pregnancy');
            $table->tinyInteger('pregnancy_duration');
            $table->integer('pregnancy_hemoglobin');
            $table->text('pregnancy_incidents');
            $table->text('medication_consumption');
            $table->text('pregnancy_complications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_pregnancy_histories');
    }
};
