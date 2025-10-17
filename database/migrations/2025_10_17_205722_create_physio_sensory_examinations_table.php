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
        Schema::create('physio_sensory_examinations', function (Blueprint $table) {
            $table->id();
            $options = ['Normal', 'Hipo', 'Hiper'];
            $table->enum('visual', $options)->comment('Penglihatan (Visual)');
            $table->enum('auditory', $options)->comment('Pendengaran (Auditory)');
            $table->enum('olfactory', $options)->comment('Penciuman (Olfactory)');
            $table->enum('gustatory', $options)->comment('Pengecapan (Gustatory)');
            $table->enum('tactile', $options)->comment('Peraba / Kulit (Tactile)');
            $table->enum('proprioceptive', $options)->comment('Otot dan Sendi (Propioceptive)');
            $table->enum('vestibular', $options)->comment('Keseimbangan (Vestibular)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_sensory_examinations');
    }
};
