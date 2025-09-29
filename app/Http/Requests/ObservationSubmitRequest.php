<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 * schema="ObservationSubmitRequest",
 * type="object",
 * required={"answers", "conclusion", "recommendation"},
 * @OA\Property(
 * property="answers",
 * type="array",
 * description="Daftar jawaban untuk setiap pertanyaan",
 * @OA\Items(
 * type="object",
 * required={"question_id", "answer"},
 * @OA\Property(property="question_id", type="integer", description="ID dari pertanyaan yang dijawab", example=27),
 * @OA\Property(property="answer", type="boolean", description="Jawaban (true/false) untuk pertanyaan", example=true),
 * @OA\Property(property="note", type="string", nullable=true, description="Catatan opsional untuk jawaban", example="Anak menunjukkan kemajuan.")
 * )
 * ),
 * @OA\Property(property="conclusion", type="string", description="Kesimpulan akhir dari terapis", example="Anak menunjukkan perkembangan yang baik sesuai usianya."),
 * @OA\Property(property="recommendation", type="string", description="Rekomendasi tindak lanjut dari terapis", example="Disarankan untuk melanjutkan sesi terapi motorik halus.")
 * )
 */
class ObservationSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'terapis';
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
            'conclusion' => ['required', 'string', 'min:10'],
            'recommendation' => ['required', 'string', 'min:10'],
        ];
    }
}
