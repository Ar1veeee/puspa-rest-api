<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peda_writing_aspects', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('hold_writing_tool_score');
            $table->text('hold_writing_tool_desc')->nullable();
            $table->tinyInteger('write_straight_down_score');
            $table->text('write_straight_down_desc')->nullable();
            $table->tinyInteger('write_straight_side_score');
            $table->text('write_straight_side_desc')->nullable();
            $table->tinyInteger('write_curved_line_score');
            $table->text('write_curved_line_desc')->nullable();
            $table->tinyInteger('write_letters_straight_score');
            $table->text('write_letters_straight_desc')->nullable();
            $table->tinyInteger('copy_letters_score');
            $table->text('copy_letters_desc')->nullable();
            $table->tinyInteger('write_own_name_score');
            $table->text('write_own_name_desc')->nullable();
            $table->tinyInteger('recognize_and_write_words_score');
            $table->text('recognize_and_write_words_desc')->nullable();
            $table->tinyInteger('write_upper_lower_case_score');
            $table->text('write_upper_lower_case_desc')->nullable();
            $table->tinyInteger('differentiate_similar_letters_score');
            $table->text('differentiate_similar_letters_desc')->nullable();
            $table->tinyInteger('write_simple_sentences_score');
            $table->text('write_simple_sentences_desc')->nullable();
            $table->tinyInteger('write_story_from_picture_score');
            $table->text('write_story_from_picture_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peda_writing_aspects');
    }
};
