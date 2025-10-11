<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddChildrenRequest extends FormRequest
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
        $familyId = Auth::user()?->guardian?->family_id;

        return [
            'child_name' => ['required', 'string', 'max:100', Rule::unique('children')->where('family_id', $familyId)],
            'child_gender' => ['required', 'string', 'in:laki-laki,perempuan'],
            'child_birth_place' => ['required', 'string', 'max:100'],
            'child_birth_date' => ['required', 'date'],
            'child_school' => ['string', 'max:100'],
            'child_address' => ['required', 'string', 'max:150'],
            'child_complaint' => ['required', 'string'],
            'child_service_choice' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'child_name.required' => 'Nama anak tidak boleh kosong.',
            'child_name.string'   => 'Nama anak harus berupa teks.',
            'child_name.max'      => 'Nama anak tidak boleh lebih dari :max karakter.',
            'child_name.unique'   => 'Nama anak tersebut sudah terdaftar di keluarga Anda.',

            'child_birth_place.required' => 'Tempat lahir tidak boleh kosong.',
            'child_birth_place.string'   => 'Tempat lahir harus berupa teks.',
            'child_birth_place.max'      => 'Tempat lahir tidak boleh lebih dari :max karakter.',

            'child_birth_date.required' => 'Tanggal lahir tidak boleh kosong.',
            'child_birth_date.date'     => 'Tanggal lahir harus berupa format tanggal yang valid.',

            'child_address.required' => 'Alamat tidak boleh kosong.',
            'child_address.string'   => 'Alamat harus berupa teks.',
            'child_address.max'      => 'Alamat tidak boleh lebih dari :max karakter.',

            'child_complaint.required' => 'Keluhan utama tidak boleh kosong.',
            'child_complaint.string'   => 'Keluhan utama harus berupa teks.',
            'child_complaint.max'      => 'Keluhan utama tidak boleh lebih dari :max karakter.',

            'child_school.string' => 'Nama sekolah harus berupa teks.',
            'child_school.max'    => 'Nama sekolah tidak boleh lebih dari :max karakter.',

            'child_service_choice.required' => 'Pilihan layanan tidak boleh kosong.',
            'child_service_choice.string'   => 'Pilihan layanan harus berupa teks.',

            'child_religion.string' => 'Agama harus berupa teks.',
            'child_religion.in'     => 'Agama yang dipilih tidak valid.',

            'child_gender.required' => 'Jenis kelamin tidak boleh kosong.',
            'child_gender.string'   => 'Jenis kelamin harus berupa teks.',
            'child_gender.in'       => 'Jenis kelamin yang dipilih tidak valid (L/P).',
        ];
    }
}
