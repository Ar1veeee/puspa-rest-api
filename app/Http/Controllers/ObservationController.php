<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\ObservationSubmitRequest;
use App\Http\Requests\ObservationUpdateRequest;
use App\Http\Resources\ObservationCompletedDetailResource;
use App\Http\Resources\ObservationQuestionsResource;
use App\Http\Resources\ObservationScheduledDetailResource;
use App\Http\Resources\ObservationsCompletedResource;
use App\Http\Resources\ObservationsPendingResource;
use App\Http\Resources\ObservationsScheduledResource;
use App\Http\Services\ObservationService;

class ObservationController extends Controller
{
    use ResponseFormatter;

    protected $observationService;

    public function __construct(ObservationService $observationService)
    {
        $this->observationService = $observationService;
    }

    public function indexPending()
    {
        $observations = $this->observationService->getObservationsPending();
        $response = ObservationsPendingResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Pending', 200);
    }

    public function indexScheduled()
    {
        $observations = $this->observationService->getObservationsScheduled();
        $response = ObservationsScheduledResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Scheduled', 200);
    }

    public function indexCompleted()
    {
        $observations = $this->observationService->getObservationsCompleted();
        $response = ObservationsCompletedResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Completed', 200);
    }

    public function showScheduled(int $observationsId)
    {
        $observation = $this->observationService->getObservationScheduledDetail($observationsId);
        $response = new ObservationScheduledDetailResource($observation);

        return $this->successResponse($response, 'Observasi Scheduled Detail', 200);
    }

    public function showCompleted(int $observationsId)
    {
        $observation = $this->observationService->getObservationCompletedDetail($observationsId);
        $response = new ObservationCompletedDetailResource($observation);

        return $this->successResponse($response, 'Observasi Completed Detail', 200);
    }

    public function showQuestion(int $observationsId)
    {
        $questions = $this->observationService->getObservationQuestions($observationsId);
        $response = ObservationQuestionsResource::collection($questions);

        return $this->successResponse($response, 'Pertanyaan Observasi', 200);
    }

    public function update(ObservationUpdateRequest $request, string $observationId)
    {
        $data = $request->validated();
        $this->observationService->updateObservationDate($data, $observationId);

        return $this->successResponse([], 'Jadwal Observasi Berhasil Diperbarui', 200);
    }

    public function submit(ObservationSubmitRequest $request, int $observationId)
    {
        $data = $request->validated();
        $this->observationService->submitObservation($data, $observationId);

        return $this->successResponse([], 'Observasi Berhasil Disimpan', 200);
    }
}
