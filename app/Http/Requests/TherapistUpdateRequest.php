<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 * schema="TherapistUpdateRequest",
 * type="object",
 * description="Semua field bersifat opsional. Hanya field yang dikirim yang akan diupdate.",
 * @OA\Property(property="username", type="string", example="dr.johndoe.updated"),
 * @OA\Property(property="email", type="string", format="email", example="dr.johndoe.new@example.com"),
 * @OA\Property(property="therapist_name", type="string", example="Dr. John Doe, S.Psi"),
 * @OA\Property(property="therapist_section", type="string", enum={"okupasi", "fisio", "wicara", "paedagog"}, example="fisio"),
 * @OA\Property(property="therapist_phone", type="string", example="081234567891")
 * )
 */
class TherapistUpdateRequest extends FormRequest
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
        $userId = $this->route('therapist')->user_id;

        return [
            'username' => [
                'sometimes', 'required', 'string', 'alpha_num', 'min:3', 'max:100',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'email' => [
                'sometimes', 'required', 'string', 'email', 'max:100',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'therapist_name' => ['sometimes', 'required', 'string', 'min:3', 'max:100'],
            'therapist_section' => ['sometimes', 'required', 'in:okupasi,fisio,wicara,paedagog'],
            'therapist_phone' => ['sometimes', 'required', 'string', 'max:100'],
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

            'password.required' => 'Password tidak boleh kosong jika ingin diubah.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu angka, dan satu simbol.',

            'therapist_name.required' => 'Nama terapis tidak boleh kosong.',
            'therapist_name.string' => 'Nama terapis harus berupa teks.',
            'therapist_name.min' => 'Nama terapis minimal harus :min karakter.',
            'therapist_name.max' => 'Nama terapis tidak boleh lebih dari :max karakter.',

            'therapist_section.required' => 'Bagian terapis tidak boleh kosong.',
            'therapist_section.in' => 'Bagian terapis yang dipilih tidak valid.',

            'therapist_phone.required' => 'Nomor telepon terapis tidak boleh kosong.',
            'therapist_phone.string' => 'Nomor telepon harus berupa teks.',
            'therapist_phone.max' => 'Nomor telepon tidak boleh lebih dari :max karakter.',
        ];
    }
}
