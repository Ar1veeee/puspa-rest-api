<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChildHealthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'allergies_age' => ['nullable', 'integer', 'min:0'],
            'fever_age' => ['nullable', 'integer', 'min:0'],
            'ear_infections_age' => ['nullable', 'integer', 'min:0'],
            'headaches_age' => ['nullable', 'integer', 'min:0'],
            'mastoiditis_age' => ['nullable', 'integer', 'min:0'],
            'sinusitis_age' => ['nullable', 'integer', 'min:0'],
            'asthma_age' => ['nullable', 'integer', 'min:0'],
            'seizures_age' => ['nullable', 'integer', 'min:0'],
            'encephalitis_age' => ['nullable', 'integer', 'min:0'],
            'high_fever_age' => ['nullable', 'integer', 'min:0'],
            'meningitis_age' => ['nullable', 'integer', 'min:0'],
            'tonsillitis_age' => ['nullable', 'integer', 'min:0'],
            'chickenpox_age' => ['nullable', 'integer', 'min:0'],
            'dizziness_age' => ['nullable', 'integer', 'min:0'],
            'measles_or_rubella_age' => ['nullable', 'integer', 'min:0'],
            'influenza_age' => ['nullable', 'integer', 'min:0'],
            'pneumonia_age' => ['nullable', 'integer', 'min:0'],
            'others' => ['nullable', 'array'],
            'others.*.condition' => ['required_with:others', 'string'],
            'others.*.age' => ['required_with:others', 'integer', 'min:0'],
            'family_similar_conditions_detail' => ['required', 'string'],
            'family_mental_disorders' => ['required', 'string'],
            'child_surgeries_detail' => ['required', 'string'],
            'special_medical_conditions' => ['required', 'string'],
            'other_medications_detail' => ['required', 'string'],
            'negative_reactions_detail' => ['nullable', 'string'],
            'hospitalization_history' => ['required', 'string'],
        ];
    }
}
