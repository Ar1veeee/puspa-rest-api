<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'child_name' => ['required', 'string', 'min:3', 'max:100'],
            'child_birth_place' => ['required', 'string', 'min:3', 'max:100'],
            'child_birth_date' => ['required', 'date'],
            'child_religion' => ['required', 'string', 'in:islam,kristen,katolik,hindu,budha,konghucu,lainnya'],
            'child_gender' => ['required', 'string', 'in:laki-laki,perempuan'],
            'child_school' => ['required', 'string', 'min:3', 'max:100'],
            'child_address' => ['required', 'string', 'min:3', 'max:150'],

            'father_name' => ['required', 'string', 'min:3', 'max:100'],
            'father_relationship' => ['required', 'string'],
            'father_birth_date' => ['required', 'date'],
            'father_occupation' => ['required'],
            'father_phone' => ['required'],

            'mother_name' => ['required'],
            'mother_relationship' => ['required'],
            'mother_birth_date' => ['required', 'date'],
            'mother_occupation' => ['required'],
            'mother_phone' => ['required'],

            'guardian_name' => ['required', 'string', 'min:3', 'max:100'],
            'guardian_relationship' => ['required', 'string', 'min:3', 'max:100'],
            'guardian_birth_date' => ['required', 'date'],
            'guardian_occupation' => ['required', 'string', 'min:3', 'max:100'],
            'guardian_phone' => ['required', 'string', 'min:3', 'max:100'],

            'child_complaint' => ['required', 'string', 'min:3', 'max:100'],
            'child_service_choice' => ['required', 'string', 'min:3', 'max:150'],
        ];
    }
}
