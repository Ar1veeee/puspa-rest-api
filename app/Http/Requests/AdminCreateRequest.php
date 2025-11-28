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
        return Auth::check() && Auth::user()->isAdmin();
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
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            'admin_name' => ['required', 'string', 'min:3', 'max:100'],
            'admin_phone' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Nama pengguna tidak boleh kosong.',
            'username.string' => 'Nama pengguna harus berupa teks.',
            'username.alpha_num' => 'Nama pengguna hanya boleh berisi huruf dan angka.',
            'username.min' => 'Nama pengguna minimal harus :min karakter.',
            'username.max' => 'Nama pengguna tidak boleh lebih dari :max karakter.',
            'username.unique' => 'Nama pengguna ini sudah digunakan.',

            'email.required' => 'Email tidak boleh kosong.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email yang dimasukkan tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email ini sudah terdaftar.',

            'password.required' => 'Password tidak boleh kosong.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu angka, dan satu simbol.',

            'admin_name.required' => 'Nama admin tidak boleh kosong.',
            'admin_name.string' => 'Nama admin harus berupa teks.',
            'admin_name.min' => 'Nama admin minimal harus :min karakter.',
            'admin_name.max' => 'Nama admin tidak boleh lebih dari :max karakter.',

            'admin_phone.required' => 'Nomor telepon admin tidak boleh kosong.',
            'admin_phone.string' => 'Nomor telepon harus berupa teks.',
            'admin_phone.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',
        ];
    }
}
