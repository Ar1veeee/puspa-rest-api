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
        Schema::create('child_education_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->boolean('currently_in_school');
            $table->integer('school_class')->nullable();
            $table->string('school_location', 150)->nullable();
            $table->boolean('long_absence_from_school');
            $table->text('long_absence_reason')->nullable();
            $table->text('academic_and_socialization_detail');
            $table->text('special_treatment_detail');
            $table->boolean('learning_support_program');
            $table->text('learning_support_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_education_histories');
    }
};
