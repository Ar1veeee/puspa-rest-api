<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('speech_oral_facial_aspects', function (Blueprint $table) {
            $table->id();

            // === WAJAH ===
            $table->enum('face_symmetry', ['normal', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])->nullable();
            $table->text('face_symmetry_note')->nullable();

            $table->enum('face_abnormal_movement', ['none', 'menyeringai', 'kedutan'])->nullable();
            $table->text('face_abnormal_movement_note')->nullable();

            $table->enum('face_muscle_flexation', ['ya', 'tidak'])->nullable();
            $table->text('face_muscle_flexation_note')->nullable();

            // === RAHANG & TMJ ===
            $table->enum('jaw_range_of_motion', ['normal', 'kurang']);
            $table->text('jaw_range_of_motion_note')->nullable();

            $table->enum('jaw_symmetry', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('jaw_symmetry_note')->nullable();

            $table->enum('jaw_movement', ['normal', 'tersentak-sentak', 'groping', 'lambat', 'tidak simetris'])->nullable();
            $table->text('jaw_movement_note')->nullable();

            $table->enum('jaw_tmj_noises', ['absent', 'kresek gigi', 'bermunculan'])->nullable();
            $table->text('jaw_tmj_noises_note')->nullable();

            // === GIGI & OKLUSI ==
            $table->enum('dental_occlusion', [
                'normal',
                'neutrocclusion (Class I)',
                'distrocclusion (Class II)',
                'mesiocclusion (Class III)'
            ])->nullable();
            $table->text('dental_occlusion_note')->nullable();

            $table->enum('dental_occlusion_taring', ['normal', 'overbite', 'underbite', 'crossbite'])->nullable();
            $table->text('dental_occlusion_taring_note')->nullable();

            $table->enum('dental_teeth', ['semua ada', 'gigi palsu', 'gigi yang hilang (spesifik)'])->nullable();
            $table->text('dental_teeth_note')->nullable();

            $table->enum('dental_arrangement', ['normal', 'bertumpuk', 'beruang', 'tidak beraturan'])->nullable();
            $table->text('dental_arrangement_note')->nullable();

            $table->enum('dental_cleanliness', ['bersih', 'kurang bersih', 'kotor'])->nullable();
            $table->text('dental_cleanliness_note')->nullable();

            // === BIBIR - MEMONYONGKAN ===
            $table->enum('lip_pouting_range_of_motion', ['normal', 'kurang']);
            $table->text('lip_pouting_range_of_motion_note')->nullable();

            $table->enum('lip_pouting_symmetry', ['normal', 'turun pada kedua sisi', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])->nullable();
            $table->text('lip_pouting_symmetry_note')->nullable();

            $table->enum('lip_pouting_tongue_strength', ['normal', 'lemah'])->nullable();
            $table->text('lip_pouting_tongue_strength_note')->nullable();

            $table->text('lip_pouting_other_note')->nullable();

            // === BIBIR - TERSENYUM ===
            $table->enum('lip_smilling_range_of_motion', ['normal', 'kurang']);
            $table->text('lip_smilling_range_of_motion_note')->nullable();

            $table->enum('lip_smilling_symmetry', ['normal', 'turun pada kedua sisi', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])->nullable();
            $table->text('lip_smilling_symmetry_note')->nullable();

            $table->text('lip_smilling_other_note')->nullable();

            // === LIDAH - WARNA & GERAKAN ===
            $table->enum('tongue_color', ['normal', 'abnormal']);
            $table->text('tongue_color_note')->nullable();

            $table->enum('tongue_abnormal_movement', ['tidak ada', 'tersentak-sentak', 'kekuan', 'menggeliat', 'fasikulasi'])->nullable();
            $table->text('tongue_abnormal_movement_note')->nullable();

            $table->enum('tongue_size', ['normal', 'kecil', 'besar'])->nullable();
            $table->text('tongue_size_note')->nullable();

            $table->enum('tongue_frenulum', ['normal', 'pendek'])->nullable();
            $table->text('tongue_frenulum_note')->nullable();

            $table->text('tongue_other_note')->nullable();

            // === LIDAH - KELUARKAN LIDAH ===
            $table->enum('tongue_out_symmetry', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('tongue_out_symmetry_note')->nullable();

            $table->enum('tongue_out_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_out_range_of_motion_note')->nullable();

            $table->enum('tongue_out_speed', ['normal', 'lambat'])->nullable();
            $table->text('tongue_out_speed_note')->nullable();

            $table->enum('tongue_out_strength', ['normal', 'lemah'])->nullable();
            $table->text('tongue_out_strength_note')->nullable();

            $table->text('tongue_out_other_note')->nullable();

            // === LIDAH - MENARIK LIDAH ===
            $table->enum('tongue_pull_symmetry', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('tongue_pull_symmetry_note')->nullable();

            $table->enum('tongue_pull_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_pull_range_of_motion_note')->nullable();

            $table->enum('tongue_pull_speed', ['normal', 'lambat'])->nullable();
            $table->text('tongue_pull_speed_note')->nullable();

            $table->text('tongue_pull_other_note')->nullable();

            // === LIDAH - KE KANAN ===
            $table->enum('tongue_to_right_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_to_right_range_of_motion_note')->nullable();

            $table->enum('tongue_to_right_strength', ['normal', 'lemah'])->nullable();
            $table->text('tongue_to_right_strength_note')->nullable();

            $table->text('tongue_to_right_other_note')->nullable();

            // === LIDAH - KE KIRI ===
            $table->enum('tongue_to_left_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_to_left_range_of_motion_note')->nullable();

            $table->enum('tongue_to_left_strength', ['normal', 'lemah'])->nullable();
            $table->text('tongue_to_left_strength_note')->nullable();

            $table->text('tongue_to_left_other_note')->nullable();

            // === LIDAH - KE BAWAH ===
            $table->enum('tongue_to_bottom_movement', ['normal', 'lambat'])->nullable();
            $table->text('tongue_to_bottom_movement_note')->nullable();

            $table->enum('tongue_to_bottom_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_to_bottom_range_of_motion_note')->nullable();

            $table->text('tongue_to_bottom_other_note')->nullable();

            // === LIDAH - KE ATAS ===
            $table->enum('tongue_to_upper_movement', ['normal', 'lambat'])->nullable();
            $table->text('tongue_to_upper_movement_note')->nullable();

            $table->enum('tongue_to_upper_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_to_upper_range_of_motion_note')->nullable();

            $table->text('tongue_to_upper_other_note')->nullable();

            // === LIDAH - KANAN KIRI BERGANTIAN ===
            $table->enum('tongue_to_left_right_movement', ['normal', 'lemah', 'menurun bertahap'])->nullable();
            $table->text('tongue_to_left_right_movement_note')->nullable();

            $table->enum('tongue_to_left_right_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_to_left_right_range_of_motion_note')->nullable();

            $table->text('tongue_to_left_right_other_note')->nullable();

            // === FARING ===
            $table->enum('pharynx_color', ['normal', 'abnormal'])->nullable();
            $table->text('pharynx_color_note')->nullable();

            $table->enum('pharynx_tonsil', ['tidak ada', 'normal', 'membesar'])->nullable();
            $table->text('pharynx_tonsil_note')->nullable();

            $table->text('pharynx_other_note')->nullable();

            // === LANGIT-LANGIT KERAS & LUNAK ===
            $table->enum('palate_color', ['normal', 'abnormal'])->nullable();
            $table->text('palate_color_note')->nullable();

            $table->enum('palate_rugae', ['ada', 'tidak ada'])->nullable();
            $table->text('palate_rugae_note')->nullable();

            $table->enum('palate_hard_height', ['normal', 'tinggi', 'rendah'])->nullable();
            $table->text('palate_hard_height_note')->nullable();

            $table->enum('palate_hard_width', ['normal', 'sempit', 'lebar'])->nullable();
            $table->text('palate_hard_width_note')->nullable();

            $table->enum('palate_growths', ['tidak ada', 'ada'])->nullable();
            $table->text('palate_growths_note')->nullable();

            $table->enum('palate_fistula', ['tidak ada', 'ada'])->nullable();
            $table->text('palate_fistula_note')->nullable();

            $table->enum('palate_soft_symmetry_at_rest', ['normal', 'kanan lebih rendah', 'kiri lebih rendah'])->nullable();
            $table->text('palate_soft_symmetry_at_rest_note')->nullable();

            $table->enum('palate_gag_reflex', ['normal', 'tidak ada', 'hipersensitif', 'hiposensitif'])->nullable();
            $table->text('palate_gag_reflex_note')->nullable();

            $table->text('palate_other_note')->nullable();

            // === FONASI ===
            $table->enum('palate_phonation_symmetry', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('palate_phonation_symmetry_note')->nullable();

            $table->enum('palate_posterior_movement', ['ada', 'tidak ada'])->nullable();
            $table->text('palate_posterior_movement_note')->nullable();

            $table->enum('palate_uvula_position', ['normal', 'bifid', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('palate_uvula_position_note')->nullable();

            $table->enum('palate_nasal_leak', ['tidak ada', 'hipernasal'])->nullable();
            $table->text('palate_nasal_leak_note')->nullable();

            $table->text('palate_phonation_other_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speech_oral_facial_aspects');
    }
};
