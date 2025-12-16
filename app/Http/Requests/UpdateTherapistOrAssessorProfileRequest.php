<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTherapistOrAssessorProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        if (!$user) {
            return false;
        }

        return $user->hasRole(['asesor', 'terapis']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user_id = $this->route('therapist')->user_id;

        return [
            'file' => ['sometimes', 'required', 'file', 'max:2048', 'mimes:jpeg,png,jpg'],
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user_id),
            ],
            'therapist_name' => ['sometimes', 'required', 'string', 'max:100'],
            'therapist_phone' => ['sometimes', 'required', 'string', 'max:20'],
            'therapist_birth_date' => ['sometimes', 'required', 'date_format:Y-m-d'],

        ];
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute harus harus diisi.',
            'string' => ':attribute harus berupa teks.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',

            'email.email' => 'Format email yang dimasukkan tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar pada akun lain.',

            'therapist_phone.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',
            'therapist_birth_date.date_format' => 'Format tanggal lahir harus YYYY-MM-DD.',

            'file.mimes' => 'Foto harus berformat JPEG, PNG, atau JPG.',
            'file.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];
    }
}
