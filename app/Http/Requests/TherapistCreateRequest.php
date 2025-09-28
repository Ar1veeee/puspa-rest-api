<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 * schema="TherapistCreateRequest",
 * type="object",
 * required={"username", "email", "password", "therapist_name", "therapist_section", "therapist_phone"},
 * @OA\Property(property="username", type="string", example="dr.johndoe"),
 * @OA\Property(property="email", type="string", format="email", example="dr.johndoe@example.com"),
 * @OA\Property(property="password", type="string", format="password", example="Password123!"),
 * @OA\Property(property="therapist_name", type="string", example="Dr. John Doe"),
 * @OA\Property(property="therapist_section", type="string", enum={"Okupasi", "Fisio", "Wicara", "Paedagog"}, example="Okupasi"),
 * @OA\Property(property="therapist_phone", type="string", example="081234567890")
 * )
 */
class TherapistCreateRequest extends FormRequest
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
            'therapist_name' => ['required', 'string', 'min:3', 'max:100'],
            'therapist_section' => 'required|in:Okupasi,Fisio,Wicara,Paedagog',
            'therapist_phone' => 'required|string|max:100',
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
            'therapist_name.required' => 'Nama terapis tidak boleh kosong.',
            'therapist_section.required' => 'Bagian terapis tidak boleh kosong.',
            'therapist_phone.required' => 'Telepon terapis tidak boleh kosong.',
        ];
    }
}
