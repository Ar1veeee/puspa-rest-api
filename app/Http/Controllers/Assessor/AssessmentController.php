<?php

namespace App\Http\Controllers\Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Resources\AssessmentListResource;
use App\Http\Resources\ParentAssessmentResource;
use App\Models\Assessment;
use App\Services\AssessmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;

    private const VALID_ASSESSOR_TYPES = [
        'paedagog_assessor',
        'wicara_assessor',
        'fisio_assessor',
        'okupasi_assessor',
    ];

    public function __construct(
        AssessmentService $assessmentService
    ) {
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

    // Show all assessment by status and type (fisio, wicara, dll)
    public function indexAssessmentsByType(Request $request, string $status): JsonResponse
    {
        $valid_status = ['scheduled', 'completed'];
        if (!in_array($status, $valid_status)) {
            return $this->errorResponse('Validation Error', ['type' => ['Jenis status tidak valid']], 422);
        }

        $validated = $request->validate([
            'type' => ['nullable', 'string', 'in:fisio,okupasi,wicara,paedagog'],
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['status'] = $status;
        $user = $request->user();

        if (!$user->hasRole(['admin', 'asesor'])) {
            return $this->errorResponse('Forbidden', ['error' => 'Hanya asesor dan admin yang memiliki izin untuk melihat daftar asesmen'], 403);
        }

        $assessments = $this->assessmentService->getAssessmentsByType($validated);

        $message = 'Daftar Asesmen ' . ucfirst($status);
        if (isset($validated['type'])) {
            $message .= ' ' . ucfirst($validated['type']);
        }
        return $this->successResponse(
            AssessmentListResource::collection($assessments),
            $message,
            200
        );
    }

    public function indexParentsAssessment(Request $request, string $status)
    {
        $valid_status = ['completed', 'pending'];
        if (!in_array($status, $valid_status)) {
            return $this->errorResponse('Validation Error', ['status' => ['Status observasi tidak valid']], 422);
        }

        $validated = $request->validate([
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['status'] = $status;
        $user = $request->user();

        if (!$user->hasRole(['admin', 'asesor'])) {
            return $this->errorResponse('Forbidden', ['error' => 'Hanya asesor dan admin yang memiliki izin untuk melihat daftar asesmen'], 403);
        }

        $assessments = $this->assessmentService->getAssessments($validated);

        $message = 'Daftar Asesmen Orang Tua';
        return $this->successResponse(
            ParentAssessmentResource::collection($assessments),
            $message,
            200
        );
    }

    public function storeAssessorAssessment(StoreAssessmentRequest $request, Assessment $assessment, string $type): JsonResponse
    {
        if (!in_array($type, self::VALID_ASSESSOR_TYPES)) {
            return $this->errorResponse(
                'Validation Error',
                ['type' => ['Tipe asesmen tidak valid. Harus salah satu dari: ' . implode(', ', self::VALID_ASSESSOR_TYPES)]],
                422
            );
        }

        $this->authorize('fillAssessor', [$assessment, $type]);

        $this->assessmentService->storeAssessorAssessment($assessment, $type, $request->validated());

        return $this->successResponse([], 'Jawaban Asesmen Berhasil Disimpan', 201);
    }
}
