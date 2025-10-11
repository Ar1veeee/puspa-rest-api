<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResendResetLinkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'exists:users,email',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Alamat email tidak boleh kosong.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.',
        ];
    }
}
