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
        Schema::create('physio_muscle_palpations', function (Blueprint $table) {
            $table->id();
            $table->text('hypertonus_aga_d')->nullable();
            $table->text('hypertonus_aga_s')->nullable();
            $table->text('hypertonus_agb_d')->nullable();
            $table->text('hypertonus_agb_s')->nullable();
            $table->text('hypertonus_perut')->nullable();
            $table->text('hypotonus_aga_d')->nullable();
            $table->text('hypotonus_aga_s')->nullable();
            $table->text('hypotonus_agb_d')->nullable();
            $table->text('hypotonus_agb_s')->nullable();
            $table->text('hypotonus_perut')->nullable();
            $table->text('flyktuatif_aga_d')->nullable();
            $table->text('flyktuatif_aga_s')->nullable();
            $table->text('flyktuatif_agb_d')->nullable();
            $table->text('flyktuatif_agb_s')->nullable();
            $table->text('flyktuatif_perut')->nullable();
            $table->text('normal_aga_d')->nullable();
            $table->text('normal_aga_s')->nullable();
            $table->text('normal_agb_d')->nullable();
            $table->text('normal_agb_s')->nullable();
            $table->text('normal_perut')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_muscle_palpations');
    }
};
