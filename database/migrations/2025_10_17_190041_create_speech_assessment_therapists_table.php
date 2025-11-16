<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('speech_assessment_therapists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained('assessments')->onDelete('cascade');
            $table->foreignId('oral_facial_aspect_id')->nullable()->constrained('speech_oral_facial_aspects')->onDelete('set null');
            $table->foreignId('language_skill_aspect_id')->nullable()->constrained('speech_language_skill_aspects')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speech_assessment_therapists');
    }
};
