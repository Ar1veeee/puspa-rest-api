<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 * schema="UserLoginRequest",
 * type="object",
 * required={"identifier", "password"},
 * @OA\Property(property="identifier", type="string", description="Bisa berupa username atau email", example="johndoe"),
 * @OA\Property(property="password", type="string", format="password", example="Password123!")
 * )
 */
class UserLoginRequest extends FormRequest
{
    /**


class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'min:3', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag(),
        ], 400));
    }
}
