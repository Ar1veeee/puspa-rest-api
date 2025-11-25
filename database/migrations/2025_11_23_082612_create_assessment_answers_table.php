<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assessment_id')
                ->constrained('assessments')
                ->onDelete('cascade');

            $table->foreignId('question_id')
                ->constrained('assessment_questions')
                ->onDelete('cascade');

            $table->enum('type',
                [
                    'umum_parent',
                    'fisio_parent',
                    'okupasi_parent',
                    'paedagog_parent',
                    'wicara_parent',
                    'fisio_assessor',
                    'okupasi_assessor',
                    'paedagog_assessor',
                    'wicara_assessor',
                ]
            );

            $table->longText('answer_value')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            $table->unique(['assessment_id', 'question_id', 'type'], 'assessment_answers_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
    }
};
