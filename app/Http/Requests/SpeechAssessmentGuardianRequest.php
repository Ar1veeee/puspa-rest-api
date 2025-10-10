<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SpeechAssessmentGuardianRequest extends FormRequest
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
            'speech_problem_description' => ['required', 'string'],
            'communication_method' => ['required', 'string'],
            'language_first_known_and_who' => ['required', 'string'],
            'main_cause' => ['required', 'string'],
            'child_awareness' => ['required', 'boolean'],
            'child_awareness_detail' => ['nullable', 'string'],
            'previous_speech_therapy' => ['required', 'boolean'],
            'previous_speech_therapy_detail' => ['nullable', 'array'],
            'previous_speech_therapy_detail.*.who' => ['nullable', 'string'],
            'previous_speech_therapy_detail.*.when' => ['nullable', 'string'],
            'previous_speech_therapy_detail.*.summary' => ['nullable', 'string'],
            'other_specialist' => ['required', 'boolean'],
            'other_specialist_detail' => ['nullable', 'array'],
            'other_specialist_detail.*.result' => ['nullable', 'string'],
            'other_specialist_detail.*.when' => ['nullable', 'string'],
            'other_specialist_detail.*.summary' => ['nullable', 'string'],
            'family_communication_disorders' => ['required', 'boolean'],
            'family_communication_disorders_detail' => ['nullable', 'string'],
            'age_child_can_express_one_word' => ['nullable', 'integer'],
            'age_child_can_express_two_words' => ['nullable', 'integer'],
            'age_child_can_express_three_plus_words' => ['nullable', 'integer'],
            'age_child_can_express_sentences' => ['nullable', 'integer'],
            'age_child_can_tell_stories' => ['nullable', 'integer'],
            'feeding_difficulty' => ['required', 'string'],
            'sound_response_description' => ['required', 'string'],
        ];
    }
}
