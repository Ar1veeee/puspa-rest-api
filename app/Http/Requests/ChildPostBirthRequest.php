<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'postbirth_condition' => ['required', 'string', 'in:normal, biru, kuning, kejang'],
            'postbirth_condition_duration' => ['nullable', 'integer'],
            'postbirth_condition_age' => ['nullable', 'integer'],
            'has_ever_fallen' => ['required', 'boolean'],
            'injured_body_part' => ['nullable', 'string'],
            'age_at_fall' => ['nullable', 'integer'],
            'other_postbirth_complications' => ['nullable', 'string'],
            'head_lift_age' => ['nullable', 'integer'],
            'prone_age' => ['nullable', 'integer'],
            'roll_over_age' => ['nullable', 'integer'],
            'sitting_age' => ['nullable', 'integer'],
            'crawling_age' => ['nullable', 'integer'],
            'standing_age' => ['nullable', 'integer'],
            'walking_age' => ['nullable', 'integer'],
            'complete_immunization' => ['required', 'boolean'],
            'uncompleted_immunization_detail' => ['nullable', 'string'],
            'exclusive_breastfeeding' => ['required', 'boolean'],
            'exclusive_breastfeeding_until_age' => ['nullable', 'integer'],
            'rice_intake_age' => ['nullable', 'integer'],
        ];
    }
}
