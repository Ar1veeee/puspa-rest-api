<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peda_counting_aspects', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('recognize_numbers_1_10_score');
            $table->text('recognize_numbers_1_10_desc')->nullable();
            $table->tinyInteger('count_concrete_objects_score');
            $table->text('count_concrete_objects_desc')->nullable();
            $table->tinyInteger('compare_quantities_score');
            $table->text('compare_quantities_desc')->nullable();
            $table->tinyInteger('recognize_math_symbols_score');
            $table->text('recognize_math_symbols_desc')->nullable();
            $table->tinyInteger('operate_addition_subtraction_score');
            $table->text('operate_addition_subtraction_desc')->nullable();
            $table->tinyInteger('operate_multiplication_division_score');
            $table->text('operate_multiplication_division_desc')->nullable();
            $table->tinyInteger('use_counting_tools_score');
            $table->text('use_counting_tools_desc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peda_counting_aspects');
    }
};
