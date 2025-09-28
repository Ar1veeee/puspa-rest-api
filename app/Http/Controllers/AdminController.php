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
    public function index(): JsonResponse
    {
        $adminsData = $this->adminService->getAllAdmin();
        $resourceData = AdminsResource::collection($adminsData);

        return $this->successResponse($resourceData, 'Daftar Semua Admin', 200);
    }

    public function store(AdminCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->adminService->createAdmin($data);

        return $this->successResponse([], 'Tambah Admin Berhasil', 201);
    }

    public function show(string $adminId): JsonResponse
    {
        $admin = $this->adminService->getAdminDetail($adminId);
        $resourceData = new adminsResource($admin);

        return $this->successResponse($resourceData, 'Detail Admin', 200);
    }

    public function update(AdminUpdateRequest $request, string $adminId): JsonResponse
    {
        $data = $request->validated();
        $this->adminService->updateAdmin($data, $adminId);

        return $this->successResponse([], 'Update Admin Berhasil', 200);
    }

    public function destroy(string $adminId): JsonResponse
    {
        $this->adminService->deleteAdmin($adminId);

        return $this->successResponse([], 'Data Terapis Berhasil Terhapus', 200);
    }
}
