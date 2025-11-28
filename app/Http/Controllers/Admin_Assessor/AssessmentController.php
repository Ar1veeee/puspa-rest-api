<?php

namespace App\Http\Controllers\Admin_Assessor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AssessmentListResource;
use App\Http\Resources\AssessmentScheduledDetailResource;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
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

    // Menampilkan asesmen terdaftar berdasarkan status (terjadwal, selesai) dan tipe (fisio, wicara, dll)
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

        if ($user->isTherapist()) {
            return $this->errorResponse('Forbidden', ['error' => 'Hanya asesor dan admin yang memiliki izin untuk melihat daftar asesmen'], 403);
        }

        $assessments = $this->assessmentService->getAssessmentsByStatus($validated);

        $response = AssessmentListResource::collection($assessments);
        $message = 'Daftar Asesmen ' . ucfirst($status);
        if (isset($validated['type'])) {
            $message .= ' ' . ucfirst($validated['type']);
        }
        return $this->successResponse($response, $message);
    }

    public function indexAnswersAssessment(Assessment $assessment, string $type)
    {
        $valid_types = [
            'paedagog_assessor',
            'wicara_assessor',
            'fisio_assessor',
            'okupasi_assessor',
            'umum_parent',
            'wicara_parent',
            'paedagog_parent',
            'okupasi_parent',
            'fisio_parent'
        ];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $response = $this->assessmentService->getAnswers($assessment, $type);

        $message = 'Riwayat Jawaban Asesmen ' . ucfirst($type);

        return $this->successResponse($response, $message, 200);
    }

    public function showDetailScheduled(Request $request, AssessmentDetail $assessment): JsonResponse
    {
        $assessment->load(['assessment.child', 'assessment.child.family.guardians']);

        $response = new AssessmentScheduledDetailResource($assessment);

        return $this->successResponse($response, 'Detail Asesment Terjadwal', 200);
    }
}
