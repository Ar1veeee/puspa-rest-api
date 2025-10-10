<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'birth_type' => ['required', 'string', Rule::in(['normal', 'operasi caesar', 'vakum'])],
            'if_normal' => [
                'nullable',
                Rule::requiredIf($this->input('birth_type') === 'normal'),
                'string',
                Rule::in(['kepala dulu', 'kaki dulu', 'pantat dulu'])
            ],
            'caesar_vacuum_reason' => [
                'nullable',
                Rule::requiredIf(fn() => in_array($this->input('birth_type'), ['operasi caesar', 'vakum'])),
                'string'
            ],
            'crying_immediately' => ['required', 'boolean'],
            'birth_condition' => ['required', 'string', Rule::in(['normal', 'biru', 'kuning', 'kejang'])],
            'birth_condition_duration' => [
                'nullable',
                Rule::requiredIf($this->input('birth_condition') !== 'normal'),
                'integer',
                'min:0'
            ],
            'incubator_used' => ['required', 'boolean'],
            'incubator_duration' => [
                'nullable',
                Rule::requiredIf($this->input('incubator_used') == true),
                'integer',
                'min:0'
            ],
            'birth_weight' => ['nullable', 'numeric', 'min:0'],
            'birth_length' => ['nullable', 'integer', 'min:0'],
            'head_circumference' => ['nullable', 'numeric', 'min:0'],
            'birth_complications_other' => ['nullable', 'string'],
            'postpartum_depression' => ['required', 'boolean'],
        ];
    }
}
