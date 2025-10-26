<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GuardianFamilyUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }

    public function rules(): array
    {
        return [
            'father_identity_number' => ['sometimes', 'nullable', 'string', 'max:40'],
            'father_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'father_phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'father_birth_date' => ['sometimes', 'nullable', 'date'],
            'father_occupation' => ['sometimes', 'nullable', 'string', 'max:100'],
            'father_relationship' => ['sometimes', 'nullable', 'string', 'max:100'],

            'mother_identity_number' => ['sometimes', 'nullable', 'string', 'max:40'],
            'mother_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'mother_phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'mother_birth_date' => ['sometimes', 'nullable', 'date'],
            'mother_occupation' => ['sometimes', 'nullable', 'string', 'max:100'],
            'mother_relationship' => ['sometimes', 'nullable', 'string', 'max:100'],

            'guardian_identity_number' => ['sometimes', 'nullable', 'string', 'max:40'],
            'guardian_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'guardian_phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'guardian_birth_date' => ['sometimes', 'nullable', 'date'],
            'guardian_occupation' => ['sometimes', 'nullable', 'string', 'max:100'],
            'guardian_relationship' => ['sometimes', 'nullable', 'string', 'max:100'],
        ];
    }
}
