<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        if (!$user) return false;

        // Asesor diperbolehkan submit assessment bagian mereka
        return $user->can('submit_assessment') || $user->can('submit_parent_assessment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|integer|exists:assessment_questions,id',
            'answers.*.answer' => 'nullable',
            'answers.*.note' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'answers.required' => 'Jawaban tidak boleh kosong.',
            'answers.min' => 'Minimal harus ada satu jawaban.',
            'answers.*.question_id.required' => 'ID pertanyaan wajib diisi.',
            'answers.*.question_id.exists' => 'Pertanyaan yang dipilih tidak valid.',
        ];
    }
}