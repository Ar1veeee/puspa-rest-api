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
        Schema::create('physio_reflex_examinations', function (Blueprint $table) {
            $table->id();

            $reflexes = [
                'moro', 'blinking', 'galant', 'atnr', 'stnr', 'sucking', 'rooting',
                'palmar_grasps', 'plantar_grasps', 'flexor_withdrawal', 'babinsky',
                'righting', 'automatic_gait_reflex', 'parachute', 'landau', 'protective_reflex'
            ];

            foreach ($reflexes as $reflex) {
                $table->text($reflex . '_result')->nullable();
                $table->text($reflex . '_primitive')->nullable();
                $table->text($reflex . '_functional')->nullable();
                $table->text($reflex . '_pathological')->nullable();
                $table->text($reflex . '_integration')->nullable();
                $table->text($reflex . '_not_synchronous')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_reflex_examinations');
    }
};
