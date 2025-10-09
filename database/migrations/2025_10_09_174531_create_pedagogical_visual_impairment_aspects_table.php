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
        Schema::create('pedagogical_visual_impairment_aspects', function (Blueprint $table) {
            $table->id();
            $table->boolean('has_visual_impairment');
            $table->boolean('wearing_glasses');
            $table->boolean('comfortable_reading_while_sitting');
            $table->boolean('comfortable_reading_while_lying_down');
            $table->boolean('daily_gadget_use');
            $table->string('gadget_exploration_duration', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagogical_visual_impairment_aspects');
    }
};
