<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\ChildBirthRequest;
use App\Http\Requests\ChildEducationRequest;
use App\Http\Requests\ChildHealthRequest;
use App\Http\Requests\ChildPostBirthRequest;
use App\Http\Requests\ChildPregnancyRequest;
use App\Http\Requests\ChildPsychosocialRequest;
use App\Http\Resources\AssessmentsDetailResource;
use App\Http\Resources\ChildrenAssessmentResource;
use App\Http\Resources\GeneralDataAssessmentResource;
use App\Http\Resources\OccupationalGuardianDataAssessmentResource;
use App\Http\Resources\PedagogicalGuardianDataAssessmentResource;
use App\Http\Resources\PhysioGuardianDataAssessmentResource;
use App\Http\Resources\SpeechGuardianDataAssessmentResource;
use App\Http\Services\AssessmentService;
use Illuminate\Http\JsonResponse;

class AssessmentController extends Controller
{
    use ResponseFormatter;

    protected $assessmentService;

    public function __construct(AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    public function storeChildPsychosocial(ChildPsychosocialRequest $request, int $assessmentId): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->createChildPsychosocialHistory($assessmentId, $data);

        return $this->successResponse([], 'Data Riwayat Psikososial Berhasil Disimpan', 201);
    }

    public function storeChildPregnancy(ChildPregnancyRequest $request, int $assessmentId): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->createChildPregnancyHistory($assessmentId, $data);

        return $this->successResponse([], 'Data Riwayat Kehamilan Berhasil Disimpan', 201);
    }

    public function storeChildBirth(ChildBirthRequest $request, int $assessmentId): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->createChildBirthHistory($assessmentId, $data);

        return $this->successResponse([], 'Data Riwayat Kelahiran Berhasil Disimpan', 201);
    }

    public function storeChildPostBirth(ChildPostBirthRequest $request, int $assessmentId): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->createChildPostBirthHistory($assessmentId, $data);

        return $this->successResponse([], 'Data Riwayat Setelah Kelahiran Berhasil Disimpan', 201);
    }

    public function storeChildHealth(ChildHealthRequest $request, int $assessmentId): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->createChildHealthHistory($assessmentId, $data);

        return $this->successResponse([], 'Data Riwayat Kesehatan Berhasil Disimpan', 201);
    }

    public function storeChildEducation(ChildEducationRequest $request, int $assessmentId): JsonResponse
    {
        $data = $request->validated();
        $this->assessmentService->createChildEducationHistory($assessmentId, $data);

        return $this->successResponse([], 'Data Riwayat Kesehatan Berhasil Disimpan', 201);
    }

    public function show(int $assessmentId)
    {
        $assessment = $this->assessmentService->getAssessmentDetail($assessmentId);
        $response = new AssessmentsDetailResource($assessment);

        return$this->successResponse($response, 'Detail Assessment Untuk Anak');
    }

    public function showGeneralData(int $assessmentId): JsonResponse
    {
        $generalData = $this->assessmentService->getGeneral($assessmentId);
        $response = new GeneralDataAssessmentResource($generalData);

        return $this->successResponse($response, 'Data Umum Assessment Untuk Anak', 200);
    }

    public function showPhysioGuardianData(int $assessmentId): JsonResponse
    {
        $physioData = $this->assessmentService->getPhysioGuardian($assessmentId);
        $response = new PhysioGuardianDataAssessmentResource($physioData);

        return $this->successResponse($response, 'Data Fisio Assessment Untuk Anak', 200);
    }

    public function showSpeechGuardianData(int $assessmentId): JsonResponse
    {
        $physioData = $this->assessmentService->getSpeechGuardian($assessmentId);
        $response = new SpeechGuardianDataAssessmentResource($physioData);

        return $this->successResponse($response, 'Data Wicara Assessment Untuk Anak', 200);
    }

    public function showOccupationalGuardianData(int $assessmentId): JsonResponse
    {
        $occupationalData = $this->assessmentService->getOccupationalGuardian($assessmentId);
        $response = new OccupationalGuardianDataAssessmentResource($occupationalData);

        return $this->successResponse($response, 'Data Okupasi Assessment Untuk Anak', 200);
    }

    public function showPedagogicalGuardianData(int $assessmentId): JsonResponse
    {
        $physioData = $this->assessmentService->getPedagogicalGuardian($assessmentId);
        $response = new PedagogicalGuardianDataAssessmentResource($physioData);

        return $this->successResponse($response, 'Data Paedagog Assessment Untuk Anak', 200);
    }

    public function indexChildren(): JsonResponse
    {
        $userId = auth()->id();
        $assessments = $this->assessmentService->getChildrenAssessment($userId);
        $response = new ChildrenAssessmentResource($assessments);

        return $this->successResponse($response, 'Daftar Assessment Semua Anak', 200);
    }
}
