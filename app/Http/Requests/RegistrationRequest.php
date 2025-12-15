<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'child_name' => ['required', 'string', 'max:100'],
            'child_gender' => ['required', 'string', 'in:laki-laki,perempuan'],
            'child_birth_place' => ['required', 'string', 'max:100'],
            'child_birth_date' => ['required', 'date'],
            'child_school' => ['nullable', 'string', 'max:100'],
            'child_address' => ['required', 'string', 'max:150'],
            'child_complaint' => ['required', 'string'],
            'child_service_choice' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'guardian_name' => ['required', 'string', 'max:100'],
            'guardian_phone' => ['required', 'string', 'max:100'],
            'guardian_type' => ['required', 'string', 'in:ayah,ibu,wali'],
        ];
    }
}
