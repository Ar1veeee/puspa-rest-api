<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 * schema="AdminCreateRequest",
 * type="object",
 * required={"username", "email", "password", "admin_name", "admin_phone"},
 * @OA\Property(property="username", type="string", example="superadmin"),
 * @OA\Property(property="email", type="string", format="email", example="super.admin@example.com"),
 * @OA\Property(property="password", type="string", format="password", example="Password123!", description="Min. 8 karakter, 1 huruf besar, 1 angka, 1 simbol"),
 * @OA\Property(property="admin_name", type="string", example="Super Admin"),
 * @OA\Property(property="admin_phone", type="string", example="081234567890")
 * )
 */
class AdminCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
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
            'admin_name' => ['required', 'string', 'min:3', 'max:100'],
            'admin_phone' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Nama pengguna tidak boleh kosong.',
            'username.alpha_num' => 'Nama pengguna hanya berisi huruf dan angka.',
            'username.min' => 'Nama pengguna minimal 3 karakter.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, angka, dan simbol.',
            'admin_name.required' => 'Nama admin tidak boleh kosong.',
            'admin_phone.required' => 'Telepon admin tidak boleh kosong.',
        ];
    }
}
