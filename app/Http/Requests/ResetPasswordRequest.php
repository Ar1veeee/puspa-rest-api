<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            'token' => 'required',
            'email' => ['required', 'string', 'email', 'max:100'],
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
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'token.required' => 'Token tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'password.required' => 'Password baru tidak boleh kosong.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal harus :min karakter.',
            'password.letters' => 'Password baru harus mengandung setidaknya satu huruf.',
            'password.mixedCase' => 'Password baru harus mengandung huruf besar dan kecil.',
            'password.numbers' => 'Password baru harus mengandung setidaknya satu angka.',
            'password.symbols' => 'Password baru harus mengandung setidaknya satu simbol.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'token' => $this->query('token'),
            'email' => urldecode($this->query('email')),
        ]);
    }
}
