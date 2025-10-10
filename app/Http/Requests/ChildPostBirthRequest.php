<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChildPostBirthRequest extends FormRequest
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
            'postbirth_condition' => ['required', 'string', Rule::in(['normal', 'biru', 'kuning', 'kejang'])],
            'postbirth_condition_duration' => [
                'nullable',
                Rule::requiredIf($this->input('postbirth_condition') !== 'normal'),
                'integer',
                'min:0'
            ],
            'postbirth_condition_age' => [
                'nullable',
                Rule::requiredIf($this->input('postbirth_condition') !== 'normal'),
                'integer',
                'min:0'
            ],
            'has_ever_fallen' => ['required', 'boolean'],
            'injured_body_part' => [
                'nullable',
                Rule::requiredIf($this->input('has_ever_fallen') == true),
                'string',
                'max:100'
            ],
            'age_at_fall' => [
                'nullable',
                Rule::requiredIf($this->input('has_ever_fallen') == true),
                'integer',
                'min:0'
            ],
            'other_postbirth_complications' => ['nullable', 'string'],
            'head_lift_age' => ['nullable', 'integer', 'min:0'],
            'prone_age' => ['nullable', 'integer', 'min:0'],
            'roll_over_age' => ['nullable', 'integer', 'min:0'],
            'sitting_age' => ['nullable', 'integer', 'min:0'],
            'crawling_age' => ['nullable', 'integer', 'min:0'],
            'climbing_age' => ['nullable', 'integer', 'min:0'],
            'standing_age' => ['nullable', 'integer', 'min:0'],
            'walking_age' => ['nullable', 'integer', 'min:0'],
            'complete_immunization' => ['required', 'boolean'],
            'uncompleted_immunization_detail' => [
                'nullable',
                Rule::requiredIf($this->input('complete_immunization') == false),
                'string'
            ],
            'exclusive_breastfeeding' => ['required', 'boolean'],
            'exclusive_breastfeeding_until_age' => [
                'nullable',
                Rule::requiredIf($this->input('exclusive_breastfeeding') == true),
                'integer',
                'min:0'
            ],
            'rice_intake_age' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
