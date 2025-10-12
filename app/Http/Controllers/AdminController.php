<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\AdminResource;
use App\Http\Services\AdminService;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
        $admins = $this->adminService->getAllAdmin();
        $response = AdminResource::collection($admins);

        return $this->successResponse($response, 'Daftar Semua Admin', 200);
    }

    public function store(AdminCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $admin = $this->adminService->createAdmin($data);

        return $this->successResponse(new AdminResource($admin), 'Tambah Admin Berhasil', 201);
    }

    public function show(Admin $admin): JsonResponse
    {
        $admin->load('user');
        $response = new AdminResource($admin);

        return $this->successResponse($response, 'Detail Admin', 200);
    }

    public function update(AdminUpdateRequest $request, Admin $admin): JsonResponse
    {
        $data = $request->validated();
        $this->adminService->updateAdmin($data, $admin);

        return $this->successResponse([], 'Update Admin Berhasil', 200);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $this->adminService->updatePassword($request->validated(), $userId);

        return $this->successResponse([], 'Update Password Berhasil', 200);
    }

    public function destroy(Admin $admin): JsonResponse
    {
        $this->adminService->deleteAdmin($admin);

        return $this->successResponse([], 'Data Admin Berhasil Terhapus', 200);
    }
}
