<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            // Parent Data
            'parent_email' => ['required', 'email'],
            'parent_phone' => ['required', 'string', 'max:20'],
            'parent_name' => ['required', 'string', 'max:100'],
            'guardian_type' => ['required', 'string', 'in:ayah,ibu,wali'],

            // Child Data
            'child_name' => ['required', 'string', 'max:100'],
            'child_gender' => ['required', 'string', 'in:laki-laki,perempuan'],
            'child_birth_place' => ['required', 'string', 'max:100'],
            'child_birth_date' => ['required', 'date'],
            'child_school' => ['nullable', 'string', 'max:100'],
            'child_address' => ['required', 'string', 'max:150'],
            'child_complaint' => ['required', 'string'],
            'child_service_choice' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_email.required' => 'Email orang tua wajib diisi.',
            'parent_phone.required' => 'Nomor HP orang tua wajib diisi.',
            'parent_name.required' => 'Nama orang tua wajib diisi.',
            'child_name.required' => 'Nama anak wajib diisi.',
            'child_gender.in' => 'Jenis kelamin harus laki-laki atau perempuan.',
        ];
    }
}
