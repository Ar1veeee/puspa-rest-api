<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occu_motoric_plannings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('bilateral_skill_stringing_beads_score');
            $table->text('bilateral_skill_stringing_beads_desc')->nullable();
            $table->tinyInteger('bilateral_skill_flipping_pages_score');
            $table->text('bilateral_skill_flipping_pages_desc')->nullable();
            $table->tinyInteger('bilateral_skill_sewing_score');
            $table->text('bilateral_skill_sewing_desc')->nullable();
            $table->tinyInteger('cutting_no_line_score');
            $table->text('cutting_no_line_desc')->nullable();
            $table->tinyInteger('cutting_straight_line_score');
            $table->text('cutting_straight_line_desc')->nullable();
            $table->tinyInteger('cutting_zigzag_line_score');
            $table->text('cutting_zigzag_line_desc')->nullable();
            $table->tinyInteger('cutting_wave_line_score');
            $table->text('cutting_wave_line_desc')->nullable();
            $table->tinyInteger('cutting_box_shape_score');
            $table->text('cutting_box_shape_desc')->nullable();
            $table->tinyInteger('memory_recall_objects_score');
            $table->text('memory_recall_objects_desc')->nullable();
            $table->tinyInteger('memory_singing_score');
            $table->text('memory_singing_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occu_motoric_plannings');
    }
};
