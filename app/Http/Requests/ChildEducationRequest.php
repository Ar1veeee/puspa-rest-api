<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChildEducationRequest extends FormRequest
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
