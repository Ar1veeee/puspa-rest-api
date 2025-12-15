<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ObservationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
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
