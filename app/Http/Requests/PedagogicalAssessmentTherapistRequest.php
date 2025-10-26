<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PedagogicalAssessmentTherapistRequest extends FormRequest
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
        // Aturan standar untuk setiap item penilaian
        $scoreRules = ['required', 'integer', 'between:0,3']; // Asumsi skor penilaian 0-3
        $descRules = ['nullable', 'string'];

        return [
            // Aspek Membaca (peda_reading_aspects)
            'recognize_letters_score' => $scoreRules,
            'recognize_letters_desc' => $descRules,
            'recognize_letter_symbols_score' => $scoreRules,
            'recognize_letter_symbols_desc' => $descRules,
            'say_alphabet_in_order_score' => $scoreRules,
            'say_alphabet_in_order_desc' => $descRules,
            'pronounce_letters_correctly_score' => $scoreRules,
            'pronounce_letters_correctly_desc' => $descRules,
            'read_vowels_score' => $scoreRules,
            'read_vowels_desc' => $descRules,
            'read_consonants_score' => $scoreRules,
            'read_consonants_desc' => $descRules,
            'read_given_words_score' => $scoreRules,
            'read_given_words_desc' => $descRules,
            'read_sentences_score' => $scoreRules,
            'read_sentences_desc' => $descRules,
            'read_quickly_score' => $scoreRules,
            'read_quickly_desc' => $descRules,
            'read_for_comprehension_score' => $scoreRules,
            'read_for_comprehension_desc' => $descRules,

            // Aspek Menulis (peda_writing_aspects)
            'hold_writing_tool_score' => $scoreRules,
            'hold_writing_tool_desc' => $descRules,
            'write_straight_down_score' => $scoreRules,
            'write_straight_down_desc' => $descRules,
            'write_straight_side_score' => $scoreRules,
            'write_straight_side_desc' => $descRules,
            'write_curved_line_score' => $scoreRules,
            'write_curved_line_desc' => $descRules,
            'write_letters_straight_score' => $scoreRules,
            'write_letters_straight_desc' => $descRules,
            'copy_letters_score' => $scoreRules,
            'copy_letters_desc' => $descRules,
            'write_own_name_score' => $scoreRules,
            'write_own_name_desc' => $descRules,
            'recognize_and_write_words_score' => $scoreRules,
            'recognize_and_write_words_desc' => $descRules,
            'write_upper_lower_case_score' => $scoreRules,
            'write_upper_lower_case_desc' => $descRules,
            'differentiate_similar_letters_score' => $scoreRules,
            'differentiate_similar_letters_desc' => $descRules,
            'write_simple_sentences_score' => $scoreRules,
            'write_simple_sentences_desc' => $descRules,
            'write_story_from_picture_score' => $scoreRules,
            'write_story_from_picture_desc' => $descRules,

            // Aspek Berhitung (peda_counting_aspects)
            'recognize_numbers_1_10_score' => $scoreRules,
            'recognize_numbers_1_10_desc' => $descRules,
            'count_concrete_objects_score' => $scoreRules,
            'count_concrete_objects_desc' => $descRules,
            'compare_quantities_score' => $scoreRules,
            'compare_quantities_desc' => $descRules,
            'recognize_math_symbols_score' => $scoreRules,
            'recognize_math_symbols_desc' => $descRules,
            'operate_addition_subtraction_score' => $scoreRules,
            'operate_addition_subtraction_desc' => $descRules,
            'operate_multiplication_division_score' => $scoreRules,
            'operate_multiplication_division_desc' => $descRules,
            'use_counting_tools_score' => $scoreRules,
            'use_counting_tools_desc' => $descRules,

            // Aspek Kesiapan Belajar (peda_learning_readiness_aspects)
            'follow_instructions_score' => $scoreRules,
            'follow_instructions_desc' => $descRules,
            'sit_calmly_score' => $scoreRules,
            'sit_calmly_desc' => $descRules,
            'not_hyperactive_score' => $scoreRules,
            'not_hyperactive_desc' => $descRules,
            'show_initiative_score' => $scoreRules,
            'show_initiative_desc' => $descRules,
            'is_cooperative_score' => $scoreRules,
            'is_cooperative_desc' => $descRules,
            'show_enthusiasm_score' => $scoreRules,
            'show_enthusiasm_desc' => $descRules,
            'complete_tasks_score' => $scoreRules,
            'complete_tasks_desc' => $descRules,

            // Aspek Pengetahuan Umum (peda_general_knowledge_aspects)
            'knows_identity_score' => $scoreRules,
            'knows_identity_desc' => $descRules,
            'show_body_parts_score' => $scoreRules,
            'show_body_parts_desc' => $descRules,
            'understand_taste_differences_score' => $scoreRules,
            'understand_taste_differences_desc' => $descRules,
            'identify_colors_score' => $scoreRules,
            'identify_colors_desc' => $descRules,
            'understand_sizes_score' => $scoreRules,
            'understand_sizes_desc' => $descRules,
            'understand_orientation_score' => $scoreRules,
            'understand_orientation_desc' => $descRules,
            'express_emotions_score' => $scoreRules,
            'express_emotions_desc' => $descRules,

            // Kesimpulan dari tabel utama (peda_assessment_therapists)
            'summary' => ['nullable', 'string'],
        ];
    }
}
