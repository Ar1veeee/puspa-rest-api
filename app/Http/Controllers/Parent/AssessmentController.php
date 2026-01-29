<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\GuardianFamilyUpdateRequest;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Resources\AssessmentsDetailResource;
use App\Http\Resources\ChildrenAssessmentResource;
use App\Services\AssessmentService;
use App\Services\GuardianService;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;
    protected $guardianService;


    public function __construct(
        AssessmentService $assessmentService,
        GuardianService   $guardianService
    ) {
        $this->assessmentService = $assessmentService;
        $this->guardianService = $guardianService;
    }

    public function indexChildrenAssessment(): JsonResponse
    {
        $userId = auth()->id();
        $childAssessment = $this->assessmentService->getChildrenAssessment($userId);

        if ($childAssessment->isEmpty()) {
            return $this->successResponse([], 'Tidak ada jadwal asesmen terjadwal saat ini');
        }

        return $this->successResponse(
            ChildrenAssessmentResource::collection($childAssessment),
            'Daftar Jadwal Asesmen Anak'
        );
    }

    public function indexParentQuestionsByType(string $type): JsonResponse
    {
        $valid_types = [
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

    public function indexAnswersAssessment(Assessment $assessment, string $type)
    {
        $this->authorize('viewAssessment', $assessment);

        $valid_types = ['umum_parent', 'wicara_parent', 'paedagog_parent', 'okupasi_parent', 'fisio_parent'];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $response = $this->assessmentService->getAnswers($assessment, $type);

        $message = 'Riwayat Jawaban Asesmen ' . ucfirst($type);

        return $this->successResponse($response, $message, 200);
    }

    public function storeParentAssessment(StoreAssessmentRequest $request, Assessment $assessment, string $type): JsonResponse
    {
        $this->authorize('viewAssessment', $assessment);

        $valid_types = ['umum_parent', 'wicara_parent', 'paedagog_parent', 'okupasi_parent', 'fisio_parent'];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $data = $request->validated();

        $this->assessmentService->storeParentAssessment($assessment, $type, $data);

        return $this->successResponse([], 'Jawaban Asesmen Berhasil Disimpan', 201);
    }

    public function show(Assessment $assessment)
    {
        $this->authorize('viewAssessment', $assessment);

        $assessment->load(['assessmentDetails.therapist', 'assessmentDetails.admin', 'assessmentDetails.assessmentAnswers']);

        return $this->successResponse(
            new AssessmentsDetailResource($assessment),
            'Detail Assessment Untuk Anak'
        );
    }

    public function downloadReportFile(Assessment $assessment)
    {
        $this->authorize('downloadReport', $assessment);

        $filePath = storage_path('app/assessment/reports/' . $assessment->report_file);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan di server');
        }

        $childName = Str::slug($assessment->child->child_name ?? 'Anak');
        $downloadName = "Laporan_Asesmen_{$childName}_" . now()->format('Y-m-d') . ".pdf";

        return response()->download($filePath, $downloadName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function updateFamilyData(GuardianFamilyUpdateRequest $request)
    {
        $primaryGuardian = $request->user()->guardian;

        $data = $request->validated();

        $this->guardianService->updateFamilyGuardians($primaryGuardian, $data);

        return $this->successResponse([], 'Data orang tua berhasil disimpan', 200);
    }
}
