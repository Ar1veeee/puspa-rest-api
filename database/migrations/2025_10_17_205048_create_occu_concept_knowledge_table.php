<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occu_concept_knowledges', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('letter_recognition_pointing_score');
            $table->text('letter_recognition_pointing_desc')->nullable();
            $table->tinyInteger('letter_recognition_reading_score');
            $table->text('letter_recognition_reading_desc')->nullable();
            $table->tinyInteger('letter_recognition_writing_score');
            $table->text('letter_recognition_writing_desc')->nullable();
            $table->tinyInteger('letter_recognition_write_on_board_score');
            $table->text('letter_recognition_write_on_board_desc')->nullable();
            $table->tinyInteger('letter_recognition_write_in_order_score');
            $table->text('letter_recognition_write_in_order_desc')->nullable();
            $table->tinyInteger('color_comprehension_pointing_score');
            $table->text('color_comprehension_pointing_desc')->nullable();
            $table->tinyInteger('color_comprehension_differentiating_score');
            $table->text('color_comprehension_differentiating_desc')->nullable();
            $table->tinyInteger('body_awareness_mentioning_score');
            $table->text('body_awareness_mentioning_desc')->nullable();
            $table->tinyInteger('body_awareness_pointing_score');
            $table->text('body_awareness_pointing_desc')->nullable();
            $table->tinyInteger('time_orientation_day_night_score');
            $table->text('time_orientation_day_night_desc')->nullable();
            $table->tinyInteger('time_orientation_days_score');
            $table->text('time_orientation_days_desc')->nullable();
            $table->tinyInteger('time_orientation_date_month_year_score');
            $table->text('time_orientation_date_month_year_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occu_concept_knowledges');
    }
};
