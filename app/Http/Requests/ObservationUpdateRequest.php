<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 * schema="ObservationUpdateRequest",
 * type="object",
 * required={"scheduled_date"},
 * @OA\Property(
 * property="scheduled_date",
 * type="string",
 * format="date",
 * description="Tanggal baru untuk jadwal observasi",
 * example="2025-10-15"
 * )
 * )
 */
class ObservationUpdateRequest extends FormRequest
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
            'scheduled_date' => ['required', 'date'],
            'scheduled_time' => ['required', 'date_format:H:i']
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_date.required' => 'Tanggal terjadwal tidak boleh kosong',
            'scheduled_time.required' => 'Waktu terjadwal tidak boleh kosong'
        ];
    }
}
