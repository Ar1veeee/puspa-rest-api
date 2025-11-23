<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('occu_balance_coordinations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('left_right_use_shoes_score');
            $table->text('left_right_use_shoes_desc')->nullable();
            $table->tinyInteger('left_right_identify_score');
            $table->text('left_right_identify_desc')->nullable();
            $table->tinyInteger('spatial_position_up_down_score');
            $table->text('spatial_position_up_down_desc')->nullable();
            $table->tinyInteger('spatial_position_out_in_score');
            $table->text('spatial_position_out_in_desc')->nullable();
            $table->tinyInteger('spatial_position_front_back_score');
            $table->text('spatial_position_front_back_desc')->nullable();
            $table->tinyInteger('spatial_position_middle_edge_score');
            $table->text('spatial_position_middle_edge_desc')->nullable();
            $table->tinyInteger('gross_motor_walk_forward_score');
            $table->text('gross_motor_walk_forward_desc')->nullable();
            $table->tinyInteger('gross_motor_walk_backward_score');
            $table->text('gross_motor_walk_backward_desc')->nullable();
            $table->tinyInteger('gross_motor_walk_sideways_score');
            $table->text('gross_motor_walk_sideways_desc')->nullable();
            $table->tinyInteger('gross_motor_tiptoe_score');
            $table->text('gross_motor_tiptoe_desc')->nullable();
            $table->tinyInteger('gross_motor_running_score');
            $table->text('gross_motor_running_desc')->nullable();
            $table->tinyInteger('gross_motor_stand_one_foot_score');
            $table->text('gross_motor_stand_one_foot_desc')->nullable();
            $table->tinyInteger('gross_motor_jump_one_foot_score');
            $table->text('gross_motor_jump_one_foot_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occu_balance_coordinations');
    }
};
