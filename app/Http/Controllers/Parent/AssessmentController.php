<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\GuardianFamilyUpdateRequest;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Resources\AssessmentsDetailResource;
use App\Http\Resources\ChildrenAssessmentResource;
use App\Http\Resources\GeneralDataAssessmentResource;
use App\Http\Resources\OccupationalGuardianDataAssessmentResource;
use App\Http\Resources\PedagogicalGuardianDataAssessmentResource;
use App\Http\Resources\PhysioGuardianDataAssessmentResource;
use App\Http\Resources\SpeechGuardianDataAssessmentResource;
use App\Http\Services\AssessmentService;
use App\Http\Services\GuardianService;
use App\Models\AssessmentDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;
    protected $guardianService;


    public function __construct(
        AssessmentService $assessmentService,
        GuardianService   $guardianService
    )
    {
        $this->assessmentService = $assessmentService;
        $this->guardianService = $guardianService;
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

    public function indexAnswersAssessment(AssessmentDetail $assessment, string $type)
    {
        $valid_types = ['general_parent', 'wicara_parent', 'paedagog_parent', 'okupasi_parent', 'fisio_parent'];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $response = $this->assessmentService->getAnswers($assessment, $type);

        $message = 'Riwayat Jawaban Asesmen ' . ucfirst($type);

        return $this->successResponse($response, $message, 200);
    }

    public function storeParentAssessment(StoreAssessmentRequest $request, AssessmentDetail $assessment, string $type): JsonResponse
    {
        $valid_types = ['general_parent', 'wicara_parent', 'paedagog_parent', 'okupasi_parent', 'fisio_parent'];
        if (!in_array($type, $valid_types)) {
            return $this->errorResponse('Validation Error', ['type' => ['Type tidak valid']], 422);
        }

        $data = $request->validated();

        $this->assessmentService->storeOrUpdateParentAssessment($data, $assessment, $type);

        return $this->successResponse([], 'Jawaban Asesmen Berhasil Disimpan', 201);
    }

    public function markAsCompleteAssessment(AssessmentDetail $assessmentDetail): JsonResponse
    {
        $assessmentDetail->load('assessment.child');
        $this->authorize('view', $assessmentDetail);

        try {
            $this->assessmentService->completedAssessment($assessmentDetail);
            return $this->successResponse([], 'Assessment telah berhasil diselesaikan', 200);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Asesmen belum dapat diselesaikan',
                $e->errors(),
                422
            );
        }
    }

    // Menampilkan jadwal asesmen semua anak yang dimiliki orang tua
    public function show(AssessmentDetail $assessment)
    {
        $this->authorize('view', $assessment);

        return $this->successResponse(
            new AssessmentsDetailResource($assessment),
            'Detail Assessment Untuk Anak'
        );
    }

    public function updateFamilyData(GuardianFamilyUpdateRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        $this->guardianService->updateGuardians($data, $userId);

        return $this->successResponse([], 'Data orang tua berhasil disimpan', 200);
    }

    private function getGuardianResourceByType(string $type, $data)
    {
        return match ($type) {
            'umum' => new GeneralDataAssessmentResource($data),
            'fisio' => new PhysioGuardianDataAssessmentResource($data),
            'wicara' => new SpeechGuardianDataAssessmentResource($data),
            'okupasi' => new OccupationalGuardianDataAssessmentResource($data),
            'paedagog' => new PedagogicalGuardianDataAssessmentResource($data),
        };
    }
}
