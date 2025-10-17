<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occu_concentration_problem_solvings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('concentration_2_commands_score');
            $table->text('concentration_2_commands_desc')->nullable();
            $table->tinyInteger('concentration_3_commands_score');
            $table->text('concentration_3_commands_desc')->nullable();
            $table->tinyInteger('concentration_4_commands_score');
            $table->text('concentration_4_commands_desc')->nullable();
            $table->tinyInteger('concentration_find_in_picture_score');
            $table->text('concentration_find_in_picture_desc')->nullable();
            $table->tinyInteger('problem_solving_puzzle_score');
            $table->text('problem_solving_puzzle_desc')->nullable();
            $table->tinyInteger('problem_solving_story_score');
            $table->text('problem_solving_story_desc')->nullable();
            $table->tinyInteger('size_comprehension_big_small_score');
            $table->text('size_comprehension_big_small_desc')->nullable();
            $table->tinyInteger('size_comprehension_tall_short_score');
            $table->text('size_comprehension_tall_short_desc')->nullable();
            $table->tinyInteger('size_comprehension_many_few_score');
            $table->text('size_comprehension_many_few_desc')->nullable();
            $table->tinyInteger('size_comprehension_long_short_score');
            $table->text('size_comprehension_long_short_desc')->nullable();
            $table->tinyInteger('number_recognition_count_forward_score');
            $table->text('number_recognition_count_forward_desc')->nullable();
            $table->tinyInteger('number_recognition_count_backward_score');
            $table->text('number_recognition_count_backward_desc')->nullable();
            $table->tinyInteger('number_recognition_symbol_score');
            $table->text('number_recognition_symbol_desc')->nullable();
            $table->tinyInteger('number_recognition_concept_score');
            $table->text('number_recognition_concept_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occu_concentration_problem_solvings');
    }
};
