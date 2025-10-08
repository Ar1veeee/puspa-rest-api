<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChildPregnancyRequest extends FormRequest
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
            'pregnancy_desired' => ['required', 'boolean'],
            'routine_checkup' => ['required', 'boolean'],
            'mother_age_at_pregnancy' => ['required', 'integer', 'min:1'],
            'pregnancy_duration' => ['required', 'integer', 'min:1'],
            'pregnancy_hemoglobin' => ['required', 'integer', 'min:1'],
            'pregnancy_incidents' => ['required', 'string'],
            'medication_consumption' => ['required', 'string'],
            'pregnancy_complications' => ['required', 'string'],
        ];
    }
}
