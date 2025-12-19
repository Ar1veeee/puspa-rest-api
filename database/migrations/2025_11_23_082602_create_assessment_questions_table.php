<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('assessment_type', 255);
            $table->string('section', 255);
            $table->string('question_code', 255)->unique()->nullable();
            $table->integer('question_number')->default(0);
            $table->text('question_text');
            $table->string('answer_type', 255);
            $table->json('answer_options')->nullable();
            $table->json('extra_schema')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('assessment_question_groups')->onDelete('set null');

            $table->index('group_id');
            $table->index('assessment_type');
            $table->index('section');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_questions');
    }
};
