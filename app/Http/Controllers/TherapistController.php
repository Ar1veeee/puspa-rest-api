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

    /**
     * @OA\Get(
     * path="/therapists",
     * operationId="getTherapistsList",
     * tags={"Therapists"},
     * summary="Mendapatkan daftar semua terapis",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Operasi berhasil",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/TherapistResource")
     * )
     * ),
     * @OA\Response(response=401, description="Unauthenticated"),
     * @OA\Response(response=403, description="Forbidden (bukan admin)")
     * )
     */
    public function index(): JsonResponse
    {
        $therapistsData = $this->therapistService->getAllTherapist();
        $resourceData = TherapistsResource::collection($therapistsData);

        return $this->successResponse($resourceData, 'Daftar Semua Terapis', 200);
    }

    /**
     * @OA\Post(
     * path="/therapists",
     * operationId="storeTherapist",
     * tags={"Therapists"},
     * summary="Membuat data terapis baru",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/TherapistCreateRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Terapis berhasil dibuat"
     * ),
     * @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function store(TherapistCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->createTherapist($data);

        return $this->successResponse([], 'Tambah Terapis Berhasil', 201);
    }

    /**
     * @OA\Get(
     * path="/therapists/{therapistId}",
     * operationId="getTherapistById",
     * tags={"Therapists"},
     * summary="Mendapatkan detail satu terapis",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="therapistId",
     * in="path",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operasi berhasil",
     * @OA\JsonContent(ref="#/components/schemas/TherapistResource")
     * ),
     * @OA\Response(response=404, description="Data terapis tidak ditemukan")
     * )
     */
    public function show(string $therapistId): JsonResponse
    {
        $therapist = $this->therapistService->getTherapistDetail($therapistId);
        $resourceData = new TherapistsResource($therapist);

        return $this->successResponse($resourceData, 'Detail Terapis', 200);
    }

    /**
     * @OA\Put(
     * path="/therapists/{therapistId}",
     * operationId="updateTherapist",
     * tags={"Therapists"},
     * summary="Memperbarui data terapis",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="therapistId",
     * in="path",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/TherapistUpdateRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Update berhasil"
     * ),
     * @OA\Response(response=404, description="Data terapis tidak ditemukan"),
     * @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function update(TherapistUpdateRequest $request, string $therapistId): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->updateTherapist($data, $therapistId);

        return $this->successResponse([], 'Update Terapis Berhasil', 200);
    }

    /**
     * @OA\Delete(
     * path="/therapists/{therapistId}",
     * operationId="deleteTherapist",
     * tags={"Therapists"},
     * summary="Menghapus data terapis",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="therapistId",
     * in="path",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="Data berhasil dihapus"
     * ),
     * @OA\Response(response=404, description="Data terapis tidak ditemukan")
     * )
     */
    public function destroy(string $therapistId): JsonResponse
    {
        $this->therapistService->deleteTherapist($therapistId);

        return $this->successResponse([], 'Data Terapis Berhasil Terhapus', 200);
    }
}
