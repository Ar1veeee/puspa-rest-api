<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\TherapistCreateRequest;
use App\Http\Requests\TherapistUpdateRequest;
use App\Http\Resources\TherapistResource;
use App\Http\Services\TherapistService;
use App\Models\Therapist;
use Illuminate\Http\JsonResponse;

class TherapistController extends Controller
{
    use ResponseFormatter;

    protected $therapistService;

    public function __construct(TherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
    }

    public function index(): JsonResponse
    {
        $therapists = $this->therapistService->getAllTherapist();
        $response = TherapistResource::collection($therapists);

        return $this->successResponse($response, 'Daftar Semua Terapis', 200);
    }

    public function store(TherapistCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->createTherapist($data);

        return $this->successResponse([], 'Tambah Terapis Berhasil', 201);
    }

    public function show(Therapist $therapist): JsonResponse
    {
        $therapist->load('user');
        $response = new TherapistResource($therapist);

        return $this->successResponse($response, 'Detail Terapis', 200);
    }

    public function update(TherapistUpdateRequest $request, Therapist $therapist): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->updateTherapist($data, $therapist);

        return $this->successResponse([], 'Update Terapis Berhasil', 200);
    }

    public function destroy(Therapist $therapist): JsonResponse
    {
        $this->therapistService->deleteTherapist($therapist);

        return $this->successResponse([], 'Data Terapis Berhasil Terhapus', 200);
    }
}
