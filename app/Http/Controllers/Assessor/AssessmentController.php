<?php

namespace App\Http\Controllers\Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Resources\ParentsAssessmentListResource;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;


    public function __construct(
        AssessmentService $assessmentService
    )
    {
        $this->assessmentService = $assessmentService;
    }

    public function indexAssessorQuestionsByType(string $type): JsonResponse
    {
        $valid_types = [
            'paedagog',
            'wicara_oral',
            'wicara_bahasa',
            'fisio',
            'okupasi',
            'parent_general',
            'parent_wicara',
            'parent_paedagog',
            'parent_okupasi',
            'parent_fisio'
        ];

        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $questions = $this->assessmentService->getQuestionsByType($type);

        $message = 'Daftar Pertanyaan Asesmen ' . ucfirst($type);

        return $this->successResponse($questions, $message, 200);
    }

    public function indexParentsAssessment(Request $request, string $status)
    {
        $valid_status = ['completed', 'pending'];
        if (!in_array($status, $valid_status)) {
            return $this->errorResponse('Validation Error', ['type' => ['Status observasi tidak valid']], 422);
        }

        $validated = $request->validate([
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['status'] = $status;
        $user = $request->user();

        if ($user->isTherapist()) {
            return $this->errorResponse('Forbidden', ['error' => 'Hanya asesor dan admin yang memiliki izin untuk melihat daftar asesmen'], 403);
        }

        $assessments = $this->assessmentService->getParentsAssessment($validated);

        $response = ParentsAssessmentListResource::collection($assessments);
        $message = 'Daftar Asesmen Orang Tua';
        return $this->successResponse($response, $message, 200);
    }

    public function storeAssessorAssessment(StoreAssessmentRequest $request, Assessment $assessment, string $type): JsonResponse
    {
        $valid_types = [
            'paedagog_assessor',
            'wicara_assessor',
            'fisio_assessor',
            'okupasi_assessor',
        ];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $data = $request->validated();

        $this->assessmentService->storeOrUpdateAssessorAssessment($data, $assessment, $type);

        return $this->successResponse([], 'Jawaban Asesmen Berhasil Disimpan', 201);
    }
}
