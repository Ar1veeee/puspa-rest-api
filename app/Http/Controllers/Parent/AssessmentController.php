<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\GuardianFamilyUpdateRequest;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Resources\AssessmentsDetailResource;
use App\Http\Resources\ChildrenAssessmentResource;
use App\Http\Services\AssessmentService;
use App\Http\Services\GuardianService;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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

        $filteredAssessments = $childAssessment->filter(function ($item) {
            return $item !== null;
        });

        if ($filteredAssessments->isEmpty()) {
            return $this->successResponse([], 'Tidak ada jadwal asesmen yang ditemukan');
        }

        return $this->successResponse(ChildrenAssessmentResource::collection($childAssessment), 'Daftar Assessment Semua Anak', 200);
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
        $valid_types = ['umum_parent', 'wicara_parent', 'paedagog_parent', 'okupasi_parent', 'fisio_parent'];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $data = $request->validated();

        $this->assessmentService->storeOrUpdateParentAssessment($data, $assessment, $type);

        return $this->successResponse([], 'Jawaban Asesmen Berhasil Disimpan', 201);
    }

    // Menampilkan tipe asesmen yang dimiliki anak
    public function show(Assessment $assessment)
    {
        $assessment->load(['assessmentDetails.therapist', 'assessmentDetails.admin']);

        return $this->successResponse(
            new AssessmentsDetailResource($assessment),
            'Detail Assessment Untuk Anak'
        );
    }

    public function downloadReportFile(Assessment $assessment)
    {
        if ($assessment->child->parent_id !== auth('parent')->id()) {
            abort(403, 'Unauthorized');
        }

        if (!$assessment->report_file) {
            abort(404, 'Laporan belum tersedia');
        }

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
        $userId = Auth::id();
        $data = $request->validated();

        $this->guardianService->updateGuardians($data, $userId);

        return $this->successResponse([], 'Data orang tua berhasil disimpan', 200);
    }
}
