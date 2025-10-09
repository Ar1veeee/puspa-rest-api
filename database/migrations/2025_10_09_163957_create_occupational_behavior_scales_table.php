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
        Schema::create('occupational_behavior_scales', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('easy_to_surrender');
            $table->tinyInteger('distracted_by_attention');
            $table->tinyInteger('difficulty_sitting_quietly_5min');
            $table->tinyInteger('cannot_concentrate_20min');
            $table->tinyInteger('often_tries_to_forget_personal_belongings');
            $table->tinyInteger('responds_without_clear_reason');
            $table->tinyInteger('refuses_to_follow_orders_even_simple');
            $table->tinyInteger('not_patient_waiting_turn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupational_behavior_scales');
    }
};
