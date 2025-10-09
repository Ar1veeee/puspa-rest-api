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
            'allergies_age' => ['nullable', 'integer'],
            'fever_age' => ['nullable', 'integer'],
            'ear_infections_age' => ['nullable', 'integer'],
            'headaches_age' => ['nullable', 'integer'],
            'mastoiditis_age' => ['nullable', 'integer'],
            'sinusitis_age' => ['nullable', 'integer'],
            'asthma_age' => ['nullable', 'integer'],
            'seizures_age' => ['nullable', 'integer'],
            'encephalitis_age' => ['nullable', 'integer'],
            'high_fever_age' => ['nullable', 'integer'],
            'meningitis_age' => ['nullable', 'integer'],
            'tonsillitis_age' => ['nullable', 'integer'],
            'chickenpox_age' => ['nullable', 'integer'],
            'dizziness_age' => ['nullable', 'integer'],
            'measles_or_rubella_age' => ['nullable', 'integer'],
            'influenza_age' => ['nullable', 'integer'],
            'other_disease' => ['nullable', 'array'],
            'other_disease.*.disease' => ['required', 'string'],
            'other_disease.*.age' => ['required', 'integer'],
            'family_similar_conditions_detail' => ['nullable', ''],
            'family_mental_disorders' => ['required', 'string'],
            'child_surgeries_detail' => ['required', 'string'],
            'special_medical_conditions' => ['required', 'string'],
            'other_medications_detail' => ['required', 'string'],
            'negative_reactions_detail' => ['nullable', 'string'],
            'hospitalization_history' => ['required', 'string'],
        ];
    }
}
