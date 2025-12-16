<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('admin')->user_id;

        return [
            'username' => [
                'sometimes', 'required', 'string', 'alpha_num', 'min:3', 'max:100',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'email' => [
                'sometimes', 'required', 'string', 'email', 'max:100',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'admin_name' => ['sometimes', 'required', 'string', 'min:3', 'max:100'],
            'admin_phone' => ['sometimes', 'required', 'string', 'max:100'],
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
