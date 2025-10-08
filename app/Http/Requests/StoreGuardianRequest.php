<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreGuardianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }

    public function rules(): array
    {
        return [
            'father_name' => ['nullable', 'string', 'max:100'],
            'father_phone' => ['nullable', 'string', 'max:20'],
            'father_birth_date' => ['nullable', 'date'],
            'father_occupation' => ['nullable', 'string', 'max:100'],
            'father_relationship' => ['nullable', 'string', 'max:100'],

            'mother_name' => ['nullable', 'string', 'max:100'],
            'mother_phone' => ['nullable', 'string', 'max:20'],
            'mother_birth_date' => ['nullable', 'date'],
            'mother_occupation' => ['nullable', 'string', 'max:100'],
            'mother_relationship' => ['nullable', 'string', 'max:100'],

            'wali_name' => ['nullable', 'string', 'max:100'],
            'wali_phone' => ['nullable', 'string', 'max:20'],
            'wali_birth_date' => ['nullable', 'date'],
            'wali_occupation' => ['nullable', 'string', 'max:100'],
            'wali_relationship' => ['nullable', 'string', 'max:100'],
        ];
    }
}
