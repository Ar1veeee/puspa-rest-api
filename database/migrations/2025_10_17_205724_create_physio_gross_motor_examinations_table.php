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
        Schema::create('physio_gross_motor_examinations', function (Blueprint $table) {
            $table->id();
            // Posisi Telentang
            $table->text('supine_head')->nullable();
            $table->text('supine_shoulder')->nullable();
            $table->text('supine_elbow')->nullable();
            $table->text('supine_wrist')->nullable();
            $table->text('supine_finger')->nullable();
            $table->text('supine_trunk')->nullable();
            $table->text('supine_hip')->nullable();
            $table->text('supine_knee')->nullable();
            $table->text('supine_ankle')->nullable();
            // Berguling
            $table->text('rolling_handling')->nullable();
            $table->text('rolling_rolling_via')->nullable();
            $table->text('rolling_trunk_rotation')->nullable();
            // Posisi Telungkup
            $table->text('prone_head_lifting')->nullable();
            $table->text('prone_head_control')->nullable();
            $table->text('prone_forearm_support')->nullable();
            $table->text('prone_hand_support')->nullable();
            $table->text('prone_hip')->nullable();
            $table->text('prone_knee')->nullable();
            $table->text('prone_ankle')->nullable();
            // Posisi Duduk
            $table->text('sitting_head_lifting')->nullable();
            $table->text('sitting_head_control')->nullable();
            $table->text('sitting_head_support')->nullable();
            $table->text('sitting_trunk_control')->nullable();
            $table->text('sitting_balance')->nullable();
            $table->text('sitting_protective_reaction')->nullable();
            $table->text('sitting_position')->nullable();
            $table->text('sitting_weight_bearing')->nullable();
            // Posisi Berdiri
            $table->text('standing_head_lifting')->nullable();
            $table->text('standing_head_control')->nullable();
            $table->text('standing_trunk_control')->nullable();
            $table->text('standing_hip')->nullable();
            $table->text('standing_knee')->nullable();
            $table->text('standing_ankle')->nullable();
            $table->text('standing_support')->nullable()->comment('Tumpuan');
            $table->enum('standing_posture', ['Good Posture', 'Poor Posture'])->nullable();
            $table->text('standing_posture_note')->nullable();
            // Berjalan
            $table->text('walking_gait_pattern')->nullable()->comment('Pola Jalan');
            $table->text('walking_balance')->nullable()->comment('Keseimbangan');
            $table->text('walking_knee_type')->nullable()->comment('Tipe Lutut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physio_gross_motor_examinations');
    }
};
