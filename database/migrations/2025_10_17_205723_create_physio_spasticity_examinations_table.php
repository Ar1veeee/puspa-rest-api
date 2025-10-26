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
        Schema::create('physio_spasticity_examinations', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('spas_head_neck_score');
            $table->tinyInteger('spas_trunk_score');
            $table->tinyInteger('spas_aga_dex_score');
            $table->tinyInteger('spas_aga_sin_score');
            $table->tinyInteger('spas_agb_dex_score');
            $table->tinyInteger('spas_agb_sin_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_spasticity_examinations');
    }
};
