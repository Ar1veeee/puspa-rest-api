<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SpeechAssessmentTherapistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pastikan hanya terapis yang login yang bisa mengirim request ini.
        return Auth::check() && Auth::user()->role === 'terapis';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Opsi untuk berbagai field enum
        $normalKurang = ['normal', 'kurang'];
        $normalLemah = ['normal', 'lemah'];
        $normalAbnormal = ['normal', 'abnormal'];
        $simetrisMiring = ['normal', 'miring ke kanan', 'miring ke kiri'];
        $normalLambat = ['normal', 'lambat'];
        $adaTidakAda = ['ada', 'tidak ada'];

        return [
            // === BAGIAN ASPEK KEMAMPUAN BAHASA ===
            'age_category' => ['required', Rule::in(['6-7 Tahun', '5-6 Tahun', '4-5 Tahun', '3-4 Tahun', '2-3 Tahun', '19-24 Bulan', '13-18 Bulan', '7-12 Bulan', '0-6 Bulan'])],
            'answers' => ['required', 'array'],
            'answers.*.skill' => ['required', 'string'],
            'answers.*.checked' => ['required', 'boolean'],

            // === BAGIAN ASPEK ORAL FASIAL ===
            // Evaluasi Bibir
            'lip_range_of_motion' => ['required', Rule::in($normalKurang)],
            'lip_range_of_motion_note' => ['nullable', 'string'],
            'lip_symmetry' => ['nullable', Rule::in(['normal', 'turun pada kedua sisi', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])],
            'lip_symmetry_note' => ['nullable', 'string'],
            'lip_tongue_strength' => ['nullable', Rule::in($normalLemah)],
            'lip_tongue_strength_note' => ['nullable', 'string'],
            'lip_other_note' => ['nullable', 'string'],

            // Evaluasi Lidah - Umum
            'tongue_color' => ['required', Rule::in($normalAbnormal)],
            'tongue_color_note' => ['nullable', 'string'],
            'tongue_abnormal_movement' => ['nullable', Rule::in(['tidak ada', 'tersentak-sentak', 'kekuan', 'menggeliat', 'fasikulasi'])],
            'tongue_abnormal_movement_note' => ['nullable', 'string'],
            'tongue_size' => ['nullable', Rule::in(['normal', 'kecil', 'besar'])],
            'tongue_size_note' => ['nullable', 'string'],
            'tongue_frenulum' => ['nullable', Rule::in(['normal', 'pendek'])],
            'tongue_frenulum_note' => ['nullable', 'string'],
            'tongue_other_note' => ['nullable', 'string'],

            // Evaluasi Lidah - Tengkurap
            'tongue_symmetry_prone' => ['nullable', Rule::in($simetrisMiring)],
            'tongue_symmetry_prone_note' => ['nullable', 'string'],
            'tongue_range_of_motion_prone' => ['nullable', Rule::in($normalKurang)],
            'tongue_range_of_motion_prone_note' => ['nullable', 'string'],
            'tongue_speed_prone' => ['nullable', Rule::in($normalLambat)],
            'tongue_speed_prone_note' => ['nullable', 'string'],
            'tongue_strength_prone' => ['nullable', Rule::in($normalLemah)],
            'tongue_strength_prone_note' => ['nullable', 'string'],
            'tongue_other_note_prone' => ['nullable', 'string'],

            // Evaluasi Lidah - Berbaring
            'tongue_symmetry_lying' => ['nullable', Rule::in($simetrisMiring)],
            'tongue_symmetry_lying_note' => ['nullable', 'string'],
            'tongue_range_of_motion_lying' => ['nullable', Rule::in($normalKurang)],
            'tongue_range_of_motion_lying_note' => ['nullable', 'string'],
            'tongue_speed_lying' => ['nullable', Rule::in($normalLambat)],
            'tongue_speed_lying_note' => ['nullable', 'string'],
            'tongue_strength_lying' => ['nullable', Rule::in($normalLemah)],
            'tongue_strength_lying_note' => ['nullable', 'string'],
            'tongue_other_note_lying' => ['nullable', 'string'],

            // Evaluasi Lidah - Spatel
            'tongue_strength_spatel_normal' => ['nullable', 'boolean'],
            'tongue_strength_spatel_note' => ['nullable', 'string'],
            'tongue_strength_spatel_other' => ['nullable', 'string'],

            // Evaluasi Lidah - Buka Mulut
            'tongue_open_mouth_symmetry' => ['nullable', Rule::in($simetrisMiring)],
            'tongue_open_mouth_symmetry_note' => ['nullable', 'string'],
            'tongue_open_mouth_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_open_mouth_range_of_motion_note' => ['nullable', 'string'],
            'tongue_open_mouth_speed' => ['nullable', Rule::in($normalLambat)],
            'tongue_open_mouth_speed_note' => ['nullable', 'string'],
            'tongue_open_mouth_strength' => ['nullable', Rule::in($normalLemah)],
            'tongue_open_mouth_strength_note' => ['nullable', 'string'],
            'tongue_open_mouth_other_note' => ['nullable', 'string'],

            // Evaluasi Lidah - Protrusion
            'tongue_protrusion_symmetry' => ['nullable', Rule::in($simetrisMiring)],
            'tongue_protrusion_symmetry_note' => ['nullable', 'string'],
            'tongue_protrusion_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'tongue_protrusion_range_of_motion_note' => ['nullable', 'string'],
            'tongue_protrusion_speed' => ['nullable', Rule::in($normalLambat)],
            'tongue_protrusion_speed_note' => ['nullable', 'string'],
            'tongue_protrusion_strength' => ['nullable', Rule::in($normalLemah)],
            'tongue_protrusion_strength_note' => ['nullable', 'string'],
            'tongue_protrusion_other_note' => ['nullable', 'string'],

            // Evaluasi Gigi
            'dental_occlusion' => ['nullable', Rule::in(['normal', 'neutrocclusion (Class I)', 'distrocclusion (Class II)', 'mesiocclusion (Class III)'])],
            'dental_occlusion_note' => ['nullable', 'string'],
            'dental_occlusion_taring' => ['nullable', Rule::in(['normal', 'overbite', 'underbite', 'crossbite'])],
            'dental_occlusion_taring_note' => ['nullable', 'string'],
            'dental_teeth' => ['nullable', Rule::in(['semua ada', 'gigi palsu', 'gigi yang hilang (spesifik)'])],
            'dental_teeth_note' => ['nullable', 'string'],
            'dental_arrangement' => ['nullable', Rule::in(['normal', 'bertumpuk', 'beruang', 'tidak beraturan'])],
            'dental_arrangement_note' => ['nullable', 'string'],
            'dental_cleanliness' => ['nullable', 'string'],
            'dental_cleanliness_note' => ['nullable', 'string'],
            'dental_other_note' => ['nullable', 'string'],

            // Evaluasi Wajah
            'face_symmetry' => ['nullable', Rule::in(['normal', 'turun pada sebelah kanan', 'turun pada sebelah kiri'])],
            'face_symmetry_note' => ['nullable', 'string'],
            'face_abnormal_movement' => ['nullable', Rule::in(['none', 'menyeringai', 'kedutan'])],
            'face_abnormal_movement_note' => ['nullable', 'string'],
            'face_muscle_flexation' => ['nullable', Rule::in(['ya', 'tidak'])],
            'face_muscle_flexation_note' => ['nullable', 'string'],
            'face_other_note' => ['nullable', 'string'],

            // Evaluasi Rahang
            'jaw_range_of_motion' => ['required', Rule::in($normalKurang)],
            'jaw_range_of_motion_note' => ['nullable', 'string'],
            'jaw_symmetry' => ['nullable', Rule::in($simetrisMiring)],
            'jaw_symmetry_note' => ['nullable', 'string'],
            'jaw_movement' => ['nullable', Rule::in(['normal', 'tersentak-sentak', 'groping', 'lambat', 'tidak simetris'])],
            'jaw_movement_note' => ['nullable', 'string'],
            'jaw_tmj_noises' => ['nullable', Rule::in(['absent', 'kresek gigi', 'bermunculan'])],
            'jaw_tmj_noises_note' => ['nullable', 'string'],
            'jaw_other_note' => ['nullable', 'string'],

            // Evaluasi Langit-langit
            'palate_color' => ['nullable', Rule::in($normalAbnormal)],
            'palate_color_note' => ['nullable', 'string'],
            'palate_rugae' => ['nullable', Rule::in($adaTidakAda)],
            'palate_rugae_note' => ['nullable', 'string'],
            'palate_hard_height' => ['nullable', Rule::in(['normal', 'tinggi', 'rendah'])],
            'palate_hard_height_note' => ['nullable', 'string'],
            'palate_hard_width' => ['nullable', Rule::in(['normal', 'sempit', 'lebar'])],
            'palate_hard_width_note' => ['nullable', 'string'],
            'palate_growths' => ['nullable', Rule::in($adaTidakAda)],
            'palate_growths_note' => ['nullable', 'string'],
            'palate_fistula' => ['nullable', Rule::in($adaTidakAda)],
            'palate_fistula_note' => ['nullable', 'string'],
            'palate_soft_symmetry' => ['nullable', Rule::in(['normal', 'kanan lebih rendah', 'kiri lebih rendah'])],
            'palate_soft_symmetry_note' => ['nullable', 'string'],
            'palate_soft_height' => ['nullable', Rule::in(['normal', 'tidak ada', 'tinggi', 'rendah', 'hipersensitif', 'hiposensitif'])],
            'palate_soft_height_note' => ['nullable', 'string'],
            'palate_other_note' => ['nullable', 'string'],

            // Langit-langit Keras - Atas
            'palate_hard_up_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'palate_hard_up_range_of_motion_note' => ['nullable', 'string'],
            'palate_hard_up_speed' => ['nullable', Rule::in($normalLambat)],
            'palate_hard_up_speed_note' => ['nullable', 'string'],
            'palate_hard_up_other_note' => ['nullable', 'string'],

            // Langit-langit Lunak - Bawah
            'palate_soft_down_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'palate_soft_down_range_of_motion_note' => ['nullable', 'string'],
            'palate_soft_down_speed' => ['nullable', Rule::in($normalLambat)],
            'palate_soft_down_speed_note' => ['nullable', 'string'],
            'palate_soft_down_other_note' => ['nullable', 'string'],

            // Langit-langit - Atas
            'palate_up_range_of_motion' => ['nullable', Rule::in($normalKurang)],
            'palate_up_range_of_motion_note' => ['nullable', 'string'],
            'palate_up_speed' => ['nullable', Rule::in($normalLambat)],
            'palate_up_speed_note' => ['nullable', 'string'],
            'palate_up_other_note' => ['nullable', 'string'],

            // Langit-langit Lateral
            'palate_lateral_movement' => ['nullable', Rule::in(['normal', 'meningkat', 'menurun bertahap'])],
            'palate_lateral_movement_note' => ['nullable', 'string'],
            'palate_lateral_range_of_motion' => ['nullable', Rule::in(['normal', 'berkurang pada sisi kiri', 'berkurang pada sisi kanan'])],
            'palate_lateral_range_of_motion_note' => ['nullable', 'string'],
            'palate_lateral_other_note' => ['nullable', 'string'],

            // Evaluasi Faring
            'pharynx_color' => ['nullable', Rule::in($normalAbnormal)],
            'pharynx_color_note' => ['nullable', 'string'],
            'pharynx_tonus' => ['nullable', Rule::in(['tidak ada', 'normal', 'membesar'])],
            'pharynx_tonus_note' => ['nullable', 'string'],
            'pharynx_other_note' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'in' => 'Nilai yang dipilih untuk :attribute tidak valid.',
            'array' => ':attribute harus berupa daftar.',
            'answers.*.skill.required' => 'Setiap item kemampuan bahasa harus memiliki teks skill.',
            'answers.*.checked.required' => 'Setiap item kemampuan bahasa harus memiliki status (dicentang/tidak).',
            'answers.*.checked.boolean' => 'Status centang harus bernilai true atau false.',
        ];
    }
}

