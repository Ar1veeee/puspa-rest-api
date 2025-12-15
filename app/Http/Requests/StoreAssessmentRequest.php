<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isParent() || Auth::user()->isAssessor();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'answers' => 'required| array|min:1',
            'answers.*.question_id' => 'required|integer|exists:assessment_questions,id',
            'answers.*.answer' => 'nullable',
            'answers.*.note' => 'nullable'
        ];
    }
}
