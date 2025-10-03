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
        Schema::create('observation_answers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('observation_id')->constrained('observations')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('observation_questions')->cascadeOnDelete();
            $table->boolean('answer');
            $table->integer('score_earned')->default(0);
            $table->text('note')->nullable();

            $table->unique(['observation_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_answers');
    }
};
