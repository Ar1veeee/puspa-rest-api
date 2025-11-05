<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateGuardianProfileRequest extends FormRequest
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
        $userId = $this->route('guardian')->user_id;

        return [
            'file' => ['sometimes', 'required', 'file', 'max:10240', 'mimes:jpeg,png,jpg'],
            'email' => [
                'sometimes', 'required', 'string', 'email', 'max:100',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'guardian_name' => ['sometimes', 'required', 'string', 'max:100'],
            'relationship_with_child' => ['sometimes', 'required', 'string', 'max:100'],
            'guardian_birth_date' => ['sometimes', 'required', 'date_format:d-m-Y'],
            'guardian_phone' => ['sometimes', 'required', 'string', 'max:20'],
            'guardian_occupation' => ['sometimes', 'required', 'string', 'max:100'],
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

            'guardian_birth_date.date_format' => 'Format tanggal lahir harus DD-MM-YYYY.',

            'guardian_phone.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',

            'file.mimes' => 'Foto harus berformat JPEG, PNG, atau JPG.',
            'file.max' => 'Ukuran foto tidak boleh lebih dari 10MB.',
        ];
    }
}
