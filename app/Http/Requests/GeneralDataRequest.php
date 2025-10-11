<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GeneralDataRequest extends FormRequest
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
            'child_order' => ['required', 'integer', 'min:1'],
            'siblings' => ['nullable', 'array'],
            'siblings.*.name' => ['required', 'string'],
            'siblings.*.age' => ['required', 'integer', 'min:0'],
            'household_members' => ['required', 'string'],
            'parent_marriage_status' => ['required', 'string', Rule::in(['menikah', 'cerai', 'lainya'])],
            'daily_language' => ['required', 'string', 'max:50'],

            'pregnancy_desired' => ['required', 'boolean'],
            'routine_checkup' => ['required', 'boolean'],
            'mother_age_at_pregnancy' => ['required', 'integer', 'min:1'],
            'pregnancy_duration' => ['required', 'integer', 'min:1'],
            'pregnancy_hemoglobin' => ['required', 'integer', 'min:1'],
            'pregnancy_incidents' => ['required', 'string'],
            'medication_consumption' => ['required', 'string'],
            'pregnancy_complications' => ['required', 'string'],

            'birth_type' => ['required', 'string', Rule::in(['normal', 'operasi caesar', 'vakum'])],
            'if_normal' => [
                'nullable',
                Rule::requiredIf($this->input('birth_type') === 'normal'),
                'string',
                Rule::in(['kepala dulu', 'kaki dulu', 'pantat dulu'])
            ],
            'caesar_vacuum_reason' => [
                'nullable',
                Rule::requiredIf(fn() => in_array($this->input('birth_type'), ['operasi caesar', 'vakum'])),
                'string'
            ],
            'crying_immediately' => ['required', 'boolean'],
            'birth_condition' => ['required', 'string', Rule::in(['normal', 'biru', 'kuning', 'kejang'])],
            'birth_condition_duration' => [
                'nullable',
                Rule::requiredIf($this->input('birth_condition') !== 'normal'),
                'integer',
                'min:0'
            ],
            'incubator_used' => ['required', 'boolean'],
            'incubator_duration' => [
                'nullable',
                Rule::requiredIf($this->input('incubator_used') == true),
                'integer',
                'min:0'
            ],
            'birth_weight' => ['nullable', 'numeric', 'min:0'],
            'birth_length' => ['nullable', 'integer', 'min:0'],
            'head_circumference' => ['nullable', 'numeric', 'min:0'],
            'birth_complications_other' => ['nullable', 'string'],
            'postpartum_depression' => ['required', 'boolean'],

            'postbirth_condition' => ['required', 'string', Rule::in(['normal', 'biru', 'kuning', 'kejang'])],
            'postbirth_condition_duration' => [
                'nullable',
                Rule::requiredIf($this->input('postbirth_condition') !== 'normal'),
                'integer',
                'min:0'
            ],
            'postbirth_condition_age' => [
                'nullable',
                Rule::requiredIf($this->input('postbirth_condition') !== 'normal'),
                'integer',
                'min:0'
            ],
            'has_ever_fallen' => ['required', 'boolean'],
            'injured_body_part' => [
                'nullable',
                Rule::requiredIf($this->input('has_ever_fallen') == true),
                'string',
                'max:100'
            ],
            'age_at_fall' => [
                'nullable',
                Rule::requiredIf($this->input('has_ever_fallen') == true),
                'integer',
                'min:0'
            ],
            'other_postbirth_complications' => ['nullable', 'string'],
            'head_lift_age' => ['nullable', 'integer', 'min:0'],
            'prone_age' => ['nullable', 'integer', 'min:0'],
            'roll_over_age' => ['nullable', 'integer', 'min:0'],
            'sitting_age' => ['nullable', 'integer', 'min:0'],
            'crawling_age' => ['nullable', 'integer', 'min:0'],
            'climbing_age' => ['nullable', 'integer', 'min:0'],
            'standing_age' => ['nullable', 'integer', 'min:0'],
            'walking_age' => ['nullable', 'integer', 'min:0'],
            'complete_immunization' => ['required', 'boolean'],
            'uncompleted_immunization_detail' => [
                'nullable',
                Rule::requiredIf($this->input('complete_immunization') == false),
                'string'
            ],
            'exclusive_breastfeeding' => ['required', 'boolean'],
            'exclusive_breastfeeding_until_age' => [
                'nullable',
                Rule::requiredIf($this->input('exclusive_breastfeeding') == true),
                'integer',
                'min:0'
            ],
            'rice_intake_age' => ['nullable', 'integer', 'min:0'],

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

            'currently_in_school' => ['required', 'boolean'],
            'school_location' => [
                'nullable',
                Rule::requiredIf($this->input('currently_in_school') == true),
                'string',
                'max:150'
            ],
            'school_class' => [
                'nullable',
                Rule::requiredIf($this->input('currently_in_school') == true),
                'integer'
            ],
            'long_absence_from_school' => ['required', 'boolean'],
            'long_absence_reason' => [
                'nullable',
                Rule::requiredIf($this->input('long_absence_from_school') == true),
                'string'
            ],
            'academic_and_socialization_detail' => ['required', 'string'],
            'special_treatment_detail' => ['required', 'string'],
            'learning_support_program' => ['required', 'boolean'],
            'learning_support_detail' => [
                'nullable',
                Rule::requiredIf($this->input('learning_support_program') == true),
                'string'
            ],
        ];
    }
}
