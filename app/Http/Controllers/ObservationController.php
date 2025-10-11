<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AssessmentUpdateRequest;
use App\Http\Requests\ObservationSubmitRequest;
use App\Http\Requests\ObservationUpdateRequest;
use App\Http\Resources\ObservationCompletedDetailResource;
use App\Http\Resources\ObservationDetailAnswerResource;
use App\Http\Resources\ObservationQuestionsResource;
use App\Http\Resources\ObservationScheduledDetailResource;
use App\Http\Resources\ObservationsCompletedResource;
use App\Http\Resources\ObservationsPendingResource;
use App\Http\Resources\ObservationsScheduledResource;
use App\Http\Services\ObservationService;
use App\Models\Observation;
use Illuminate\Http\JsonResponse;

class ObservationController extends Controller
{
    use ResponseFormatter;

    protected $observationService;

    public function __construct(ObservationService $observationService)
    {
        $this->observationService = $observationService;
    }

    public function indexPending(): JsonResponse
    {
        $observations = $this->observationService->getObservationsPending();
        $response = ObservationsPendingResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Pending', 200);
    }

    public function indexScheduled(): JsonResponse
    {
        $observations = $this->observationService->getObservationsScheduled();
        $response = ObservationsScheduledResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Scheduled', 200);
    }

    public function indexCompleted(): JsonResponse
    {
        $observations = $this->observationService->getObservationsCompleted();
        $response = ObservationsCompletedResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Completed', 200);
    }

    public function showScheduled(Observation $observation): JsonResponse
    {
        $observation->load(['child', 'child.family.guardians']);
        $response = new ObservationScheduledDetailResource($observation);

        return $this->successResponse($response, 'Observasi Scheduled Detail', 200);
    }

    public function showCompleted(Observation $observation): JsonResponse
    {
        $observation->load(['child', 'child.family.guardians']);
        $response = new ObservationCompletedDetailResource($observation);

        return $this->successResponse($response, 'Observasi Completed Detail', 200);
    }

    public function showDetailAnswer(Observation $observation): JsonResponse
    {
        $observation->load('observation_answers.observation_question');
        $response = new ObservationDetailAnswerResource($observation);

        return $this->successResponse($response, 'Observasi Detail Answer', 200);
    }

    public function showQuestion(Observation $observation): JsonResponse
    {
        $questions = $this->observationService->getObservationQuestions($observation->id);
        $response = new ObservationQuestionsResource($questions);

        return $this->successResponse($response, 'Pertanyaan Observasi', 200);
    }

    public function update(ObservationUpdateRequest $request, Observation $observation): JsonResponse
    {
        $data = $request->validated();
        $this->observationService->updateObservationDate($data, $observation);

        return $this->successResponse([], 'Jadwal Observasi Berhasil Diperbarui', 200);
    }

    public function submit(ObservationSubmitRequest $request, Observation $observation): JsonResponse
    {
        $data = $request->validated();
        $this->observationService->submitObservation($data, $observation);

        return $this->successResponse([], 'Observasi Berhasil Disimpan', 200);
    }

    public function assessmentAgreement(AssessmentUpdateRequest $request, Observation $observation): JsonResponse
    {
        $data = $request->validated();
        $this->observationService->assessmentAgreement($data, $observation);

        return $this->successResponse([], 'Assessment Berhasil Diperbarui', 200);
    }
}
