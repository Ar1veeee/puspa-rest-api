<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChildPsychosocialRequest extends FormRequest
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
            'child_order' => ['required', 'integer', 'min:1'],
            'siblings' => ['nullable', 'array'],
            'siblings.*.name' => ['required', 'string'],
            'siblings.*.age' => ['required', 'integer', 'min:0'],
            'household_members' => ['required', 'string'],
            'parent_marriage_status' => ['required', 'string', Rule::in(['menikah', 'cerai', 'lainya'])],
            'daily_language' => ['required', 'string', 'max:50'],
        ];
    }
}
