<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Resources\AdminsResource;
use App\Http\Services\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    use ResponseFormatter;

    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @OA\Get(
     * path="/admins",
     * operationId="getAdminsList",
     * tags={"Admins"},
     * summary="Mendapatkan daftar semua admin",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Operasi berhasil",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/AdminResource")
     * )
     * ),
     * @OA\Response(response=401, description="Unauthenticated"),
     * @OA\Response(response=403, description="Forbidden (bukan super admin)")
     * )
     */
    public function index(): JsonResponse
    {
        $adminsData = $this->adminService->getAllAdmin();
        $resourceData = AdminsResource::collection($adminsData);

        return $this->successResponse($resourceData, 'Daftar Semua Admin', 200);
    }

    /**
     * @OA\Post(
     * path="/admins",
     * operationId="storeAdmin",
     * tags={"Admins"},
     * summary="Membuat data admin baru",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/AdminCreateRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Admin berhasil dibuat"
     * ),
     * @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function store(AdminCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->adminService->createAdmin($data);

        return $this->successResponse([], 'Tambah Admin Berhasil', 201);
    }

    /**
     * @OA\Get(
     * path="/admins/{admin_id}",
     * operationId="getAdminById",
     * tags={"Admins"},
     * summary="Mendapatkan detail satu admin",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="adminId",
     * in="path",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operasi berhasil",
     * @OA\JsonContent(ref="#/components/schemas/AdminResource")
     * ),
     * @OA\Response(response=404, description="Data admin tidak ditemukan")
     * )
     */
    public function show(string $adminId): JsonResponse
    {
        $admin = $this->adminService->getAdminDetail($adminId);
        $resourceData = new adminsResource($admin);

        return $this->successResponse($resourceData, 'Detail Admin', 200);
    }

    /**
     * @OA\Put(
     * path="/admins/{admin_id}",
     * operationId="updateAdmin",
     * tags={"Admins"},
     * summary="Memperbarui data admin",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="adminId",
     * in="path",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/AdminUpdateRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Update berhasil"
     * ),
     * @OA\Response(response=404, description="Data admin tidak ditemukan"),
     * @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function update(AdminUpdateRequest $request, string $adminId): JsonResponse
    {
        $data = $request->validated();
        $this->adminService->updateAdmin($data, $adminId);

        return $this->successResponse([], 'Update Admin Berhasil', 200);
    }

    /**
     * @OA\Delete(
     * path="/admins/{admin_id}",
     * operationId="deleteAdmin",
     * tags={"Admins"},
     * summary="Menghapus data admin",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="adminId",
     * in="path",
     * required=true,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="Data berhasil dihapus"
     * ),
     * @OA\Response(response=404, description="Data admin tidak ditemukan")
     * )
     */
    public function destroy(string $adminId): JsonResponse
    {
        $this->adminService->deleteAdmin($adminId);

        return $this->successResponse([], 'Data Terapis Berhasil Terhapus', 200);
    }
}
