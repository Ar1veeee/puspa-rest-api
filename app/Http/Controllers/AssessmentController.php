<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\GeneralDataRequest;
use App\Http\Resources\AssessmentsDetailResource;
use App\Http\Resources\ChildrenAssessmentResource;
use App\Http\Resources\GeneralDataAssessmentResource;
use App\Http\Resources\OccupationalGuardianDataAssessmentResource;
use App\Http\Resources\PedagogicalGuardianDataAssessmentResource;
use App\Http\Resources\PhysioGuardianDataAssessmentResource;
use App\Http\Resources\SpeechGuardianDataAssessmentResource;
use App\Http\Services\AssessmentService;
use App\Models\Assessment;
use Illuminate\Http\JsonResponse;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;

    public function __construct(AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    public function storeGeneralData(GeneralDataRequest $request, Assessment $assessment): JsonResponse
    {
        $this->authorize('storeHistory', $assessment);
        $this->assessmentService->createGeneralData($assessment, $request->validated());
        return $this->successResponse([], 'Data Umum Berhasil Disimpan', 201);
    }

    public function show(Assessment $assessment)
    {
        $this->authorize('view', $assessment);
        return $this->successResponse(new AssessmentsDetailResource($assessment), 'Detail Assessment Untuk Anak');
    }

    public function showGeneralData(Assessment $assessment): JsonResponse
    {
        $this->authorize('view', $assessment);
        $generalData = $this->assessmentService->getGeneral($assessment);
        return $this->successResponse(new GeneralDataAssessmentResource($generalData), 'Data Umum Assessment Untuk Anak');
    }

    public function showPhysioGuardianData(Assessment $assessment): JsonResponse
    {
        $this->authorize('view', $assessment);
        $physioData = $this->assessmentService->getPhysioGuardian($assessment);
        return $this->successResponse(new PhysioGuardianDataAssessmentResource($physioData), 'Data Fisio Assessment Untuk Anak');
    }

    public function showSpeechGuardianData(Assessment $assessment): JsonResponse
    {
        $this->authorize('view', $assessment);
        $speechData = $this->assessmentService->getSpeechGuardian($assessment);
        return $this->successResponse(new SpeechGuardianDataAssessmentResource($speechData), 'Data Wicara Assessment Untuk Anak');
    }

    public function showOccupationalGuardianData(Assessment $assessment): JsonResponse
    {
        $this->authorize('view', $assessment);
        $occupationalData = $this->assessmentService->getOccupationalGuardian($assessment);
        return $this->successResponse(new OccupationalGuardianDataAssessmentResource($occupationalData), 'Data Okupasi Assessment Untuk Anak');
    }

    public function showPedagogicalGuardianData(Assessment $assessment): JsonResponse
    {
        $this->authorize('view', $assessment);
        $pedagogicalData = $this->assessmentService->getPedagogicalGuardian($assessment);
        return $this->successResponse(new PedagogicalGuardianDataAssessmentResource($pedagogicalData), 'Data Paedagog Assessment Untuk Anak');
    }

    public function indexChildren(): JsonResponse
    {
        $userId = auth()->id();
        $childAssessment = $this->assessmentService->getChildrenAssessment($userId);
        return $this->successResponse(ChildrenAssessmentResource::collection($childAssessment), 'Daftar Assessment Semua Anak');
    }
}
