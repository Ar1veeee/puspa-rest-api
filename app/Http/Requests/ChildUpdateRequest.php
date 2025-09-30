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
            'child_address' => ['required', 'string', 'min:3', 'max:100'],

            'father_name' => ['required', 'string', 'min:3', 'max:100'],
            'father_relationship' => ['required', 'string'],
            'father_age' => ['required', 'integer'],
            'father_occupation' => ['required'],
            'father_phone' => ['required'],

            'mother_name' => ['required'],
            'mother_relationship' => ['required'],
            'mother_age' => ['required'],
            'mother_occupation' => ['required'],
            'mother_phone' => ['required'],

            'guardian_name' => [''],
            'guardian_relationship' => [''],
            'guardian_age' => [''],
            'guardian_occupation' => [''],
            'guardian_phone' => [''],
        ];
    }
}
