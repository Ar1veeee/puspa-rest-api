<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'school_location' => ['nullable', 'string'],
            'school_class' => ['nullable', 'integer'],
            'long_absence_from_school' => ['required', 'boolean'],
            'long_absence_reason' => ['nullable', 'string'],
            'academic_and_socialization_detail' => ['required', 'string'],
            'special_treatment_detail' => ['required', 'string'],
            'learning_support_program' => ['required', 'boolean'],
            'learning_support_detail' => ['required', 'string'],
        ];
    }
}
