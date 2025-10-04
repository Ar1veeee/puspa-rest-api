<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
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

class ObservationController extends Controller
{
    use ResponseFormatter;

    protected $observationService;

    public function __construct(ObservationService $observationService)
    {
        $this->observationService = $observationService;
    }

    /**
     * @OA\Get(
     * path="/observations/pending",
     * operationId="getPendingObservations",
     * tags={"Observations"},
     * summary="Daftar observasi berstatus 'Pending'",
     * description="Mengambil daftar semua observasi yang menunggu penjadwalan. (Khusus Admin)",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Berhasil mengambil data",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ObservationsPendingResource"))
     * ),
     * @OA\Response(response=401, description="Unauthenticated"),
     * @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function indexPending()
    {
        $observations = $this->observationService->getObservationsPending();
        $response = ObservationsPendingResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Pending', 200);
    }

    /**
     * @OA\Get(
     * path="/observations/scheduled",
     * operationId="getScheduledObservations",
     * tags={"Observations"},
     * summary="Daftar observasi berstatus 'Scheduled'",
     * description="Mengambil daftar semua observasi yang sudah dijadwalkan.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Berhasil mengambil data",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ObservationsScheduledResource"))
     * )
     * )
     */
    public function indexScheduled()
    {
        $observations = $this->observationService->getObservationsScheduled();
        $response = ObservationsScheduledResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Scheduled', 200);
    }

    /**
     * @OA\Get(
     * path="/observations/completed",
     * operationId="getCompletedObservations",
     * tags={"Observations"},
     * summary="Daftar observasi berstatus 'Completed'",
     * description="Mengambil daftar semua observasi yang sudah selesai. (Khusus Terapis)",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Berhasil mengambil data",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ObservationsCompletedResource"))
     * )
     * )
     */
    public function indexCompleted()
    {
        $observations = $this->observationService->getObservationsCompleted();
        $response = ObservationsCompletedResource::collection($observations);

        return $this->successResponse($response, 'Daftar Observasi Completed', 200);
    }

    /**
     * @OA\Get(
     * path="/observations/scheduled/{observationId}",
     * operationId="getScheduledObservationDetail",
     * tags={"Observations"},
     * summary="Detail observasi yang sudah dijadwalkan",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="observationId", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Berhasil mengambil data",
     * @OA\JsonContent(ref="#/components/schemas/ObservationScheduledDetailResource")
     * ),
     * @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function showScheduled(int $observationsId)
    {
        $observation = $this->observationService->getObservationScheduledDetail($observationsId);
        $response = new ObservationScheduledDetailResource($observation);

        return $this->successResponse($response, 'Observasi Scheduled Detail', 200);
    }

    /**
     * @OA\Get(
     * path="/observations/completed/{observationId}",
     * operationId="getCompletedObservationDetail",
     * tags={"Observations"},
     * summary="Detail observasi yang sudah selesai",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="observationId", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Berhasil mengambil data",
     * @OA\JsonContent(ref="#/components/schemas/ObservationCompletedDetailResource")
     * ),
     * @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function showCompleted(int $observationsId)
    {
        $observation = $this->observationService->getObservationCompletedDetail($observationsId);
        $response = new ObservationCompletedDetailResource($observation);

        return $this->successResponse($response, 'Observasi Completed Detail', 200);
    }

    public function showDetailAnswer(int $observationsId)
    {
        $observation = $this->observationService->getObservationDetailAnswer($observationsId);
        $response = new ObservationDetailAnswerResource($observation);

        return $this->successResponse($response, 'Observasi Detail Answer', 200);
    }

    /**
     * @OA\Get(
     * path="/observations/question/{observationId}",
     * operationId="getObservationQuestions",
     * tags={"Observations"},
     * summary="Daftar pertanyaan untuk sebuah observasi",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="observationId", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(
     * response=200,
     * description="Berhasil mengambil data",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ObservationQuestionResource"))
     * ),
     * @OA\Response(response=404, description="Observasi tidak ditemukan")
     * )
     */
    public function showQuestion(int $observationsId)
    {
        $questions = $this->observationService->getObservationQuestions($observationsId);
        $response = ObservationQuestionsResource::collection($questions);

        return $this->successResponse($response, 'Pertanyaan Observasi', 200);
    }

    /**
     * @OA\Put(
     * path="/observations/{observationId}",
     * operationId="updateObservationDate",
     * tags={"Observations"},
     * summary="Update tanggal jadwal observasi",
     * description="Memperbarui tanggal jadwal untuk observasi yang berstatus 'Pending'. (Khusus Admin)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="observationId", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ObservationUpdateRequest")),
     * @OA\Response(response=200, description="Berhasil diperbarui"),
     * @OA\Response(response=404, description="Tidak ditemukan"),
     * @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function update(ObservationUpdateRequest $request, string $observationId)
    {
        $data = $request->validated();
        $this->observationService->updateObservationDate($data, $observationId);

        return $this->successResponse([], 'Jadwal Observasi Berhasil Diperbarui', 200);
    }

    /**
     * @OA\Post(
     * path="/observations/submit/{observationId}",
     * operationId="submitObservation",
     * tags={"Observations"},
     * summary="Submit hasil observasi",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="observationId", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/ObservationSubmitRequest")),
     * @OA\Response(response=200, description="Berhasil disimpan"),
     * @OA\Response(response=403, description="Observasi sudah selesai"),
     * @OA\Response(response=404, description="Observasi tidak ditemukan")
     * )
     */
    public function submit(ObservationSubmitRequest $request, int $observationId)
    {
        $data = $request->validated();
        $this->observationService->submitObservation($data, $observationId);

        return $this->successResponse([], 'Observasi Berhasil Disimpan', 200);
    }
}
