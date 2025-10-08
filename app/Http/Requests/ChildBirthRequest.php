<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChildBirthRequest extends FormRequest
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
        return [
            'birth_type' => ['required', 'string', 'in:normal,operasi caesar, vakum'],
            'if_normal' => ['nullable', 'string', 'in:kepala dulu, kaki dulu, pantat dulu'],
            'caesar_vacuum_reason' => ['nullable', 'string'],
            'crying_immediately' => ['required', 'boolean'],
            'birth_condition' => ['required', 'string', 'in:normal, biru, kuning, kejang'],
            'birth_condition_duration' => ['nullable', 'integer'],
            'incubator_used' => ['required', 'boolean'],
            'incubator_duration' => ['nullable', 'integer'],
            'birth_weight' => ['nullable', 'decimal:2'],
            'birth_length' => ['nullable', 'integer'],
            'head_circumference' => ['nullable', 'decimal:2'],
            'birth_complications_other' => ['nullable', 'string'],
            'postpartum_depression' => ['required', 'boolean'],
        ];
    }
}
