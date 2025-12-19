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
            $table->id();
            $table->unsignedBigInteger('observation_id');
            $table->unsignedBigInteger('question_id');
            $table->boolean('answer');
            $table->integer('score_earned')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('observation_id')->references('id')->on('observations')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('observation_questions')->onDelete('cascade');

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
