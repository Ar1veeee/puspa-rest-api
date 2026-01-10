<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'child_name' => ['required', 'string', 'max:100'],
            'child_gender' => ['required', 'string', 'in:laki-laki,perempuan'],
            'child_birth_place' => ['required', 'string', 'max:100'],
            'child_birth_date' => ['required', 'date'],
            'child_school' => ['nullable', 'string', 'max:100'],
            'child_address' => ['required', 'string', 'max:150'],
            'child_complaint' => ['required', 'string'],
            'child_service_choice' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'guardian_name' => ['required', 'string', 'max:100'],
            'guardian_phone' => ['required', 'string', 'max:100'],
            'guardian_type' => ['required', 'string', 'in:ayah,ibu,wali'],
        ];
    }

    public function messages(): array
    {
        return [
            'child_name.required' => 'Nama anak wajib diisi.',
            'child_name.string' => 'Nama anak harus berupa teks.',
            'child_name.max' => 'Nama anak maksimal 100 karakter.',

            'child_gender.required' => 'Jenis kelamin anak wajib dipilih.',
            'child_gender.in' => 'Jenis kelamin anak harus laki-laki atau perempuan.',

            'child_birth_place.required' => 'Tempat lahir anak wajib diisi.',
            'child_birth_place.max' => 'Tempat lahir anak maksimal 100 karakter.',

            'child_birth_date.required' => 'Tanggal lahir anak wajib diisi.',
            'child_birth_date.date' => 'Tanggal lahir anak tidak valid.',

            'child_school.string' => 'Nama sekolah harus berupa teks.',
            'child_school.max' => 'Nama sekolah maksimal 100 karakter.',

            'child_address.required' => 'Alamat anak wajib diisi.',
            'child_address.max' => 'Alamat anak maksimal 150 karakter.',

            'child_complaint.required' => 'Keluhan anak wajib diisi.',

            'child_service_choice.required' => 'Pilihan layanan wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',

            'guardian_name.required' => 'Nama wali wajib diisi.',
            'guardian_name.max' => 'Nama wali maksimal 100 karakter.',

            'guardian_phone.required' => 'Nomor telepon wali wajib diisi.',
            'guardian_phone.max' => 'Nomor telepon wali maksimal 100 karakter.',

            'guardian_type.required' => 'Jenis wali wajib dipilih.',
            'guardian_type.in' => 'Jenis wali harus ayah, ibu, atau wali.',
        ];
    }
}
