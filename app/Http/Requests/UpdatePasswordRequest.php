<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => ['required', 'string', 'current_password'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'current_password.required' => 'Password saat ini tidak boleh kosong.',
            'current_password.current_password' => 'Password saat ini yang Anda masukkan salah.',

            'password.required' => 'Password baru tidak boleh kosong.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal harus :min karakter.',
            'password.letters' => 'Password baru harus mengandung setidaknya satu huruf.',
            'password.mixedCase' => 'Password baru harus mengandung huruf besar dan kecil.',
            'password.numbers' => 'Password baru harus mengandung setidaknya satu angka.',
            'password.symbols' => 'Password baru harus mengandung setidaknya satu simbol.',
        ];
    }
}
