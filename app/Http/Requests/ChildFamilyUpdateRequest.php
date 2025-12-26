<?php

namespace App\Http\Requests;

use App\Rules\UniqueGuardianIdentityNumber;
use Illuminate\Foundation\Http\FormRequest;

class ChildFamilyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('edit_child') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $familyId = $this->route('child')?->family_id;

        return [
            'child_name' => ['nullable', 'string', 'max:100'],
            'child_gender' => ['nullable', 'string', 'in:laki-laki,perempuan'],
            'child_birth_place' => ['nullable', 'string', 'max:100'],
            'child_birth_date' => ['nullable', 'date'],
            'child_religion' => ['nullable', 'string', 'in:islam,kristen,katolik,hindu,budha,konghucu,lainnya'],
            'child_school' => ['string', 'max:100'],
            'child_address' => ['nullable', 'string', 'max:150'],
            'child_complaint' => ['nullable', 'string'],
            'child_service_choice' => ['nullable', 'string'],

            'father_identity_number' => [
                'sometimes',
                'nullable',
                'string',
                'max:40',
                new UniqueGuardianIdentityNumber($familyId)
            ],
            'father_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'father_phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'father_birth_date' => ['sometimes', 'nullable', 'date'],
            'father_occupation' => ['sometimes', 'nullable', 'string', 'max:100'],
            'father_relationship' => ['sometimes', 'nullable', 'string', 'max:100'],

            'mother_identity_number' => [
                'sometimes',
                'nullable',
                'string',
                'max:40',
                new UniqueGuardianIdentityNumber($familyId)
            ],
            'mother_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'mother_phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'mother_birth_date' => ['sometimes', 'nullable', 'date'],
            'mother_occupation' => ['sometimes', 'nullable', 'string', 'max:100'],
            'mother_relationship' => ['sometimes', 'nullable', 'string', 'max:100'],

            'guardian_identity_number' => [
                'sometimes',
                'nullable',
                'string',
                'max:40',
                new UniqueGuardianIdentityNumber($familyId)
            ],
            'guardian_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'guardian_phone' => ['sometimes', 'nullable', 'string', 'max:20'],
            'guardian_birth_date' => ['sometimes', 'nullable', 'date'],
            'guardian_occupation' => ['sometimes', 'nullable', 'string', 'max:100'],
            'guardian_relationship' => ['sometimes', 'nullable', 'string', 'max:100'],
        ];
    }
}
