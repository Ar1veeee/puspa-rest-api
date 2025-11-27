<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentUpdateRequest;
use App\Http\Resources\AssessmentListResource;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\Observation;
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

    // Menampilkan asesmen terdaftar berdasarkan status (terjadwal, selesai)
    public function indexAssessmentsByStatus(Request $request, string $status): JsonResponse
    {
        $valid_status = ['scheduled', 'completed'];
        if (!in_array($status, $valid_status)) {
            return $this->errorResponse('Validation Error', ['type' => ['Jenis status tidak valid']], 422);
        }

        $validated = $request->validate([
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['status'] = $status;
        $user = $request->user();

        if ($user->role === 'terapis') {
            return $this->errorResponse('Forbidden', ['error' => 'Hanya asesor dan admin yang memiliki izin untuk melihat daftar asesmen'], 403);
        }

        $assessments = $this->assessmentService->getAssessmentsByStatus($validated);

        $response = AssessmentListResource::collection($assessments);
        $message = 'Daftar Asesmen ' . ucfirst($status);

        return $this->successResponse($response, $message);
    }

    public function updateAssessmentDate(AssessmentUpdateRequest $request, Assessment $assessment): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->updateScheduledDate($data, $assessment);

        return $this->successResponse([], 'Jadwal Assessment Berhasil Diperbarui', 200);
    }
}
