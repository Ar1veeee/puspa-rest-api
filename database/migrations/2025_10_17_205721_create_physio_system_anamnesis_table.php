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
        Schema::create('physio_system_anamnesis', function (Blueprint $table) {
            $table->id();
            $table->text('head_and_neck')->nullable()->comment('Kepala dan leher');
            $table->text('cardiovascular')->nullable();
            $table->text('respiratory')->nullable();
            $table->text('gastrointestinal')->nullable();
            $table->text('urogenital')->nullable();
            $table->text('musculoskeletal')->nullable();
            $table->text('nervous_system')->nullable()->comment('Nervorum');
            $table->text('sensory')->nullable()->comment('Sensoris');
            $table->text('motoric')->nullable()->comment('Motorik (Kasar, Halus)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_system_anamnesis');
    }
};
