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

            // Evaluasi Bibir
            $table->enum('lip_range_of_motion', ['normal', 'kurang']);
            $table->text('lip_range_of_motion_note')->nullable();
            $table->enum('lip_symmetry', ['normal', 'turun pada kedua sisi', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])->nullable();
            $table->text('lip_symmetry_note')->nullable();
            $table->enum('lip_tongue_strength', ['normal', 'lemah'])->nullable();
            $table->text('lip_tongue_strength_note')->nullable();
            $table->text('lip_other_note')->nullable();

            // Evaluasi Lidah - Umum
            $table->enum('tongue_color', ['normal', 'abnormal']);
            $table->text('tongue_color_note')->nullable();
            $table->enum('tongue_abnormal_movement', ['tidak ada', 'tersentak-sentak', 'kekuan', 'menggeliat', 'fasikulasi'])->nullable();
            $table->text('tongue_abnormal_movement_note')->nullable();
            $table->enum('tongue_size', ['normal', 'kecil', 'besar'])->nullable();
            $table->text('tongue_size_note')->nullable();
            $table->enum('tongue_frenulum', ['normal', 'pendek'])->nullable();
            $table->text('tongue_frenulum_note')->nullable();
            $table->text('tongue_other_note')->nullable();

            // Evaluasi Lidah - Tengkurap
            $table->enum('tongue_symmetry_prone', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('tongue_symmetry_prone_note')->nullable();
            $table->enum('tongue_range_of_motion_prone', ['normal', 'kurang'])->nullable();
            $table->text('tongue_range_of_motion_prone_note')->nullable();
            $table->enum('tongue_speed_prone', ['normal', 'lambat'])->nullable();
            $table->text('tongue_speed_prone_note')->nullable();
            $table->enum('tongue_strength_prone', ['normal', 'lemah'])->nullable();
            $table->text('tongue_strength_prone_note')->nullable();
            $table->text('tongue_other_note_prone')->nullable();

            // Evaluasi Lidah - Berbaring
            $table->enum('tongue_symmetry_lying', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('tongue_symmetry_lying_note')->nullable();
            $table->enum('tongue_range_of_motion_lying', ['normal', 'kurang'])->nullable();
            $table->text('tongue_range_of_motion_lying_note')->nullable();
            $table->enum('tongue_speed_lying', ['normal', 'lambat'])->nullable();
            $table->text('tongue_speed_lying_note')->nullable();
            $table->enum('tongue_strength_lying', ['normal', 'lemah'])->nullable();
            $table->text('tongue_strength_lying_note')->nullable();
            $table->text('tongue_other_note_lying')->nullable();

            // Evaluasi Lidah - Spatel
            $table->boolean('tongue_strength_spatel_normal')->nullable();
            $table->text('tongue_strength_spatel_note')->nullable();
            $table->text('tongue_strength_spatel_other')->nullable();

            // Evaluasi Lidah - Buka Mulut
            $table->enum('tongue_open_mouth_symmetry', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('tongue_open_mouth_symmetry_note')->nullable();
            $table->enum('tongue_open_mouth_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_open_mouth_range_of_motion_note')->nullable();
            $table->enum('tongue_open_mouth_speed', ['normal', 'lambat'])->nullable();
            $table->text('tongue_open_mouth_speed_note')->nullable();
            $table->enum('tongue_open_mouth_strength', ['normal', 'lemah'])->nullable();
            $table->text('tongue_open_mouth_strength_note')->nullable();
            $table->text('tongue_open_mouth_other_note')->nullable();

            // Evaluasi Lidah - Protrusion
            $table->enum('tongue_protrusion_symmetry', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('tongue_protrusion_symmetry_note')->nullable();
            $table->enum('tongue_protrusion_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('tongue_protrusion_range_of_motion_note')->nullable();
            $table->enum('tongue_protrusion_speed', ['normal', 'lambat'])->nullable();
            $table->text('tongue_protrusion_speed_note')->nullable();
            $table->enum('tongue_protrusion_strength', ['normal', 'lemah'])->nullable();
            $table->text('tongue_protrusion_strength_note')->nullable();
            $table->text('tongue_protrusion_other_note')->nullable();

            // Evaluasi Gigi
            $table->enum('dental_occlusion', ['normal', 'neutrocclusion (Class I)', 'distrocclusion (Class II)', 'mesiocclusion (Class III)'])->nullable();
            $table->text('dental_occlusion_note')->nullable();
            $table->enum('dental_occlusion_taring', ['normal', 'overbite', 'underbite', 'crossbite'])->nullable();
            $table->text('dental_occlusion_taring_note')->nullable();
            $table->enum('dental_teeth', ['semua ada', 'gigi palsu', 'gigi yang hilang (spesifik)'])->nullable();
            $table->text('dental_teeth_note')->nullable();
            $table->enum('dental_arrangement', ['normal', 'bertumpuk', 'beruang', 'tidak beraturan'])->nullable();
            $table->text('dental_arrangement_note')->nullable();
            $table->text('dental_cleanliness')->nullable();
            $table->text('dental_cleanliness_note')->nullable();
            $table->text('dental_other_note')->nullable();

            // Evaluasi Wajah
            $table->enum('face_symmetry', ['normal', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])->nullable();
            $table->text('face_symmetry_note')->nullable();
            $table->enum('face_abnormal_movement', ['none', 'menyeringai', 'kedutan'])->nullable();
            $table->text('face_abnormal_movement_note')->nullable();
            $table->enum('face_muscle_flexation', ['ya', 'tidak'])->nullable();
            $table->text('face_muscle_flexation_note')->nullable();
            $table->text('face_other_note')->nullable();

            // Evaluasi Rahang
            $table->enum('jaw_range_of_motion', ['normal', 'kurang']);
            $table->text('jaw_range_of_motion_note')->nullable();
            $table->enum('jaw_symmetry', ['normal', 'miring ke kanan', 'miring ke kiri'])->nullable();
            $table->text('jaw_symmetry_note')->nullable();
            $table->enum('jaw_movement', ['normal', 'tersentak-sentak', 'groping', 'lambat', 'tidak simetris'])->nullable();
            $table->text('jaw_movement_note')->nullable();
            $table->enum('jaw_tmj_noises', ['absent', 'kresek gigi', 'bermunculan'])->nullable();
            $table->text('jaw_tmj_noises_note')->nullable();
            $table->text('jaw_other_note')->nullable();

            // Evaluasi Langit-langit
            $table->enum('palate_color', ['normal', 'abnormal'])->nullable();
            $table->text('palate_color_note')->nullable();
            $table->enum('palate_rugae', ['ada', 'tidak ada'])->nullable();
            $table->text('palate_rugae_note')->nullable();
            $table->enum('palate_hard_height', ['normal', 'tinggi', 'rendah'])->nullable();
            $table->text('palate_hard_height_note')->nullable();
            $table->enum('palate_hard_width', ['normal', 'sempit', 'lebar'])->nullable();
            $table->text('palate_hard_width_note')->nullable();
            $table->enum('palate_growths', ['ada', 'tidak ada'])->nullable();
            $table->text('palate_growths_note')->nullable();
            $table->enum('palate_fistula', ['ada', 'tidak ada'])->nullable();
            $table->text('palate_fistula_note')->nullable();
            $table->enum('palate_soft_symmetry', ['normal', 'kanan lebih rendah', 'kiri lebih rendah'])->nullable();
            $table->text('palate_soft_symmetry_note')->nullable();
            $table->enum('palate_soft_height', ['normal', 'tidak ada', 'tinggi', 'rendah', 'hipersensitif', 'hiposensitif'])->nullable();
            $table->text('palate_soft_height_note')->nullable();
            $table->text('palate_other_note')->nullable();

            // Langit-langit Keras - Atas
            $table->enum('palate_hard_up_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('palate_hard_up_range_of_motion_note')->nullable();
            $table->enum('palate_hard_up_speed', ['normal', 'lambat'])->nullable();
            $table->text('palate_hard_up_speed_note')->nullable();
            $table->text('palate_hard_up_other_note')->nullable();

            // Langit-langit Lunak - Bawah
            $table->enum('palate_soft_down_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('palate_soft_down_range_of_motion_note')->nullable();
            $table->enum('palate_soft_down_speed', ['normal', 'lambat'])->nullable();
            $table->text('palate_soft_down_speed_note')->nullable();
            $table->text('palate_soft_down_other_note')->nullable();

            // Langit-langit - Atas
            $table->enum('palate_up_range_of_motion', ['normal', 'kurang'])->nullable();
            $table->text('palate_up_range_of_motion_note')->nullable();
            $table->enum('palate_up_speed', ['normal', 'lambat'])->nullable();
            $table->text('palate_up_speed_note')->nullable();
            $table->text('palate_up_other_note')->nullable();

            // Langit-langit Lateral
            $table->enum('palate_lateral_movement', ['normal', 'meningkat', 'menurun bertahap'])->nullable();
            $table->text('palate_lateral_movement_note')->nullable();
            $table->enum('palate_lateral_range_of_motion', ['normal', 'berkurang pada sisi kiri', 'berkurang pada sisi kanan'])->nullable();
            $table->text('palate_lateral_range_of_motion_note')->nullable();
            $table->text('palate_lateral_other_note')->nullable();

            // Evaluasi Faring
            $table->enum('pharynx_color', ['normal', 'abnormal'])->nullable();
            $table->text('pharynx_color_note')->nullable();
            $table->enum('pharynx_tonus', ['tidak ada', 'normal', 'membesar'])->nullable();
            $table->text('pharynx_tonus_note')->nullable();
            $table->text('pharynx_other_note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speech_oral_facial_aspects');
    }
};
