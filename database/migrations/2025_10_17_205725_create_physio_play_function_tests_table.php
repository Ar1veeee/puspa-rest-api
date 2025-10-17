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
        Schema::create('physio_play_function_tests', function (Blueprint $table) {
            $table->id();
            $table->text('play_type')->nullable()->comment('Jenis Permainan');
            $table->text('follow_object')->nullable();
            $table->text('follow_sound')->nullable();
            $table->text('reach_object')->nullable();
            $table->text('grasping')->nullable();
            $table->text('differentiate_color')->nullable();
            $table->text('focus_attention')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_play_function_tests');
    }
};
