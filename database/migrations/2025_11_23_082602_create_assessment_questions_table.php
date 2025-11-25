<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('group_id')->nullable()->index();
            $table->foreign('group_id')->references('id')->on('assessment_question_groups')->onDelete('cascade');

            $table->string('assessment_type')->index();
            $table->string('section')->index(); // will store group_key

            $table->string('question_code')->nullable()->unique();
            $table->integer('question_number')->default(0);

            $table->text('question_text');
            $table->string('answer_type');
            $table->json('answer_options')->nullable();
            $table->json('extra_schema')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_questions');
    }
};
