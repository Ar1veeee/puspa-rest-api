<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peda_assessment_therapists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained('assessments')->onDelete('cascade');
            $table->foreignUlid('therapist_id')->constrained('therapists')->onDelete('cascade');
            $table->foreignId('reading_aspect_id')->nullable()->constrained('peda_reading_aspects')->onDelete('set null');
            $table->foreignId('writing_aspect_id')->nullable()->constrained('peda_writing_aspects')->onDelete('set null');
            $table->foreignId('counting_aspect_id')->nullable()->constrained('peda_counting_aspects')->onDelete('set null');
            $table->foreignId('learning_readiness_aspect_id')->nullable()->constrained('peda_learning_readiness_aspects')->onDelete('set null');
            $table->foreignId('general_knowledge_aspect_id')->nullable()->constrained('peda_general_knowledge_aspects')->onDelete('set null');
            $table->text('summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peda_assessment_therapists');
    }
};

