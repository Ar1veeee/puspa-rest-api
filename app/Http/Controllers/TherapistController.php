<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter as HelpersResponseFormatter;
use App\Http\Requests\TherapistCreateRequest;
use App\Http\Requests\TherapistUpdateRequest;
use App\Http\Resources\TherapistsResource;
use App\Http\Services\TherapistService;
use Illuminate\Http\JsonResponse;

class TherapistController extends Controller
{
    use HelpersResponseFormatter;

    protected $therapistService;

    public function __construct(TherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
    }

    public function index(): JsonResponse
    {
        $therapistsData = $this->therapistService->getAllTherapist();
        $resourceData = TherapistsResource::collection($therapistsData);

        return $this->successResponse($resourceData, 'Daftar Semua Terapis', 200);
    }

    public function store(TherapistCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->createTherapist($data);

        return $this->successResponse([], 'Tambah Terapis Berhasil', 201);
    }

    public function show(string $therapistId): JsonResponse
    {
        $therapist = $this->therapistService->getTherapistDetail($therapistId);
        $resourceData = new TherapistsResource($therapist);

        return $this->successResponse($resourceData, 'Detail Terapis', 200);
    }

    public function update(TherapistUpdateRequest $request, string $therapistId): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->updateTherapist($data, $therapistId);

        return $this->successResponse([], 'Update Terapis Berhasil', 200);
    }

    public function destroy(string $therapistId): JsonResponse
    {
        $this->therapistService->deleteTherapist($therapistId);

        return $this->successResponse([], 'Data Terapis Berhasil Terhapus', 200);
    }
}
