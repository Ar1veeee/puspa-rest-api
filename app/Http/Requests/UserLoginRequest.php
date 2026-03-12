<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'min:3', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'identifier.required' => 'Email atau username wajib diisi.',
            'identifier.min' => 'Email atau username minimal :min karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal :min karakter.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu angka, dan satu simbol.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag(),
        ], 422));
    }
}
