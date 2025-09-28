<?php

namespace App\Http\Requests;

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
            'username' => ['required', 'string', 'alpha_num', 'min:3', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.alpha_num' => 'Username hanya berisi huruf dan angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak benar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, angka, dan simbol.',
        ];
    }
}
