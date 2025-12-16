<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObservationSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('submit_observation') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array', 'min:1'],
            'answers.*.question_id' => ['required', 'integer', 'exists:observation_questions,id'],
            'answers.*.answer' => ['required', 'boolean'],
            'answers.*.note' => ['nullable', 'string'],
            'conclusion' => ['required', 'string', 'min:1'],
            'recommendation' => ['required', 'string', 'min:1'],
            'fisio' => ['boolean', 'nullable'],
            'wicara' => ['boolean', 'nullable'],
            'paedagog' => ['boolean', 'nullable'],
            'okupasi' => ['boolean', 'nullable'],
        ];
    }
}
