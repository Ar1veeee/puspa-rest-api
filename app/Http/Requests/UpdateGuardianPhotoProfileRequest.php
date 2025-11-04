<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateGuardianPhotoProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'user';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('guardian')->user_id;

        return [
            'file' => ['sometimes', 'required', 'file', 'max:10240', 'mimes:jpeg,png,jpg'],
        ];
    }

    /**
     * Pesan error kustom dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute harus harus diisi.',
            'file.mimes' => 'Foto harus berformat JPEG, PNG, atau JPG.',
            'file.max' => 'Ukuran foto tidak boleh lebih dari 10MB.',
        ];
    }
}
