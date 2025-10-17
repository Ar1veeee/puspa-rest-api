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
            $table->tinyInteger('head_neck_score');
            $table->tinyInteger('trunk_score');
            $table->tinyInteger('aga_dex_score');
            $table->tinyInteger('aga_sin_score');
            $table->tinyInteger('agb_dex_score');
            $table->tinyInteger('agb_sin_score');
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
