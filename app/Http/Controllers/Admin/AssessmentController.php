<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentUpdateRequest;
use App\Http\Resources\AssessmentListAdminResource;
use App\Models\Assessment;
use App\Services\AssessmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;

    public function __construct(AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    // Display registered assessments based on status (scheduled, completed) and type (fisio, wicara, etc.)
    public function indexAssessments(Request $request, string $status): JsonResponse
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

        $response = AssessmentListAdminResource::collection($assessments);
        $message = 'Daftar Asesmen ' . ucfirst($status);
        if (isset($validated['type'])) {
            $message .= ' ' . ucfirst($validated['type']);
        }
        return $this->successResponse($response, $message);
    }

    public function updateAssessmentDate(AssessmentUpdateRequest $request, Assessment $assessment): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->updateScheduledDate($assessment, $data);

        return $this->successResponse([], 'Jadwal Assessment Berhasil Diperbarui', 200);
    }
}
