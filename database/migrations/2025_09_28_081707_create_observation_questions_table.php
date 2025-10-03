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
        Schema::create('observation_questions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('question_code', 6)->unique();
            $table->enum('age_category', ['balita', 'anak-anak', 'remaja', 'lainya']);
            $table->integer('question_number');
            $table->text('question_text');
            $table->integer('score');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['age_category', 'question_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_questions');
    }
};
