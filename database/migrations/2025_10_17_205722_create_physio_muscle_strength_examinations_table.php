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
        Schema::create('physio_muscle_strength_examinations', function (Blueprint $table) {
            $table->id();
            $options = ['X', 'O', 'T', 'R'];
            $table->enum('str_trunk_score', $options);
            $table->enum('str_aga_dex_score', $options);
            $table->enum('str_aga_sin_score', $options);
            $table->enum('str_agb_dex_score', $options);
            $table->enum('str_agb_sin_score', $options);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_muscle_strength_examinations');
    }
};
