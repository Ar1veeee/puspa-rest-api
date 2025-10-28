<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 * schema="RegistrationRequest",
 * type="object",
 * required={
 * "child_name", "child_gender", "child_birth_place", "child_birth_date", "child_address", "child_complaint", "child_service_choice",
 * "email", "guardian_name", "guardian_phone", "guardian_type"
 * },
 * @OA\Property(property="child_name", type="string", example="Citra Lestari"),
 * @OA\Property(property="child_gender", type="string", enum={"laki-laki", "perempuan"}, example="Perempuan"),
 * @OA\Property(property="child_birth_place", type="string", example="Surakarta"),
 * @OA\Property(property="child_birth_date", type="string", format="date", example="2018-05-20"),
 * @OA\Property(property="child_school", type="string", nullable=true, example="SDN 1 Pagi"),
 * @OA\Property(property="child_address", type="string", example="Jl. Merdeka No. 10"),
 * @OA\Property(property="child_complaint", type="string", example="Sulit berkonsentrasi saat belajar"),
 * @OA\Property(property="child_service_choice", type="string", example="Terapi Okupasi"),
 * @OA\Property(property="email", type="string", format="email", example="wali.baru@example.com"),
 * @OA\Property(property="guardian_name", type="string", example="Budi Santoso"),
 * @OA\Property(property="guardian_phone", type="string", example="081234567890"),
 * @OA\Property(property="guardian_type", type="string", enum={"ayah", "ibu", "wali"}, example="ayah")
 * )
 */
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
}
