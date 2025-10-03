<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 * schema="AdminUpdateRequest",
 * type="object",
 * description="Semua field bersifat opsional. Hanya field yang dikirim yang akan diupdate.",
 * @OA\Property(property="username", type="string", example="superadmin_updated"),
 * @OA\Property(property="email", type="string", format="email", example="super.admin.new@example.com"),
 * @OA\Property(property="admin_name", type="string", example="Super Admin Name Updated"),
 * @OA\Property(property="admin_phone", type="string", example="081234567891")
 * )
 */
class AdminUpdateRequest extends FormRequest
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
            'admin_name.required' => 'Nama admin tidak boleh kosong.',
            'admin_phone.required' => 'Telepon admin tidak boleh kosong.',
        ];
    }
}
