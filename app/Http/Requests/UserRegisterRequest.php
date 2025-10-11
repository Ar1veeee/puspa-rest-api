<?php

namespace App\Http\Requests;

use App\Rules\ObservationCompleted;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="UserRegisterRequest",
 * type="object",
 * required={"username", "email", "password"},
 * @OA\Property(property="username", type="string", example="johndoe"),
 * @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 * @OA\Property(property="password", type="string", format="password", example="Password123!", description="Min. 8 karakter, 1 huruf besar, 1 angka, 1 simbol"),
 * @OA\Property(property="password_confirmation", type="string", format="password", example="Password123!")
 * )
 */
class UserRegisterRequest extends FormRequest
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
            'username' => ['required', 'string', 'alpha_num', 'min:3', 'max:100', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:100',
                'unique:users,email',
                'exists:guardians,temp_email',
                new ObservationCompleted,
            ],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Nama pengguna tidak boleh kosong.',
            'username.alpha_num' => 'Nama pengguna hanya berisi huruf dan angka.',

            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar sebagai pengguna.',
            'email.exists' => 'Email tidak ditemukan. Silakan lakukan pendaftaran terlebih dahulu.',

            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, angka, dan simbol.',
        ];
    }
}
