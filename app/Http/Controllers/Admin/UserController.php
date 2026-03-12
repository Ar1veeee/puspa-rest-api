<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AdminCreateRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Requests\ChildFamilyUpdateRequest;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\TherapistCreateRequest;
use App\Http\Requests\TherapistUpdateRequest;
use App\Http\Resources\AdminResource;
use App\Http\Resources\ChildDetailResource;
use App\Http\Resources\TherapistResource;
use App\Models\Admin;
use App\Models\Child;
use App\Models\Therapist;
use App\Services\AdminService;
use App\Services\ChildService;
use App\Services\TherapistService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ResponseFormatter;

    protected $adminService;
    protected $therapistService;
    protected $childService;


    public function __construct(
        AdminService     $adminService,
        TherapistService $therapistService,
        ChildService     $childService,
    ) {
        $this->adminService = $adminService;
        $this->therapistService = $therapistService;
        $this->childService = $childService;
    }

    public function storeAdmin(AdminCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->adminService->store($data);

        return $this->successResponse(null, 'Tambah Admin Berhasil', 201);
    }

    public function storeTherapist(TherapistCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->store($data);

        return $this->successResponse([], 'Tambah Terapis Berhasil', 201);
    }

    public function showAdminDetail(Admin $admin): JsonResponse
    {
        $admin->load('user');
        $response = new AdminResource($admin);

        return $this->successResponse($response, 'Detail Admin', 200);
    }

    public function showTherapistDetail(Therapist $therapist): JsonResponse
    {
        $therapist->load('user');
        $response = new TherapistResource($therapist);

        return $this->successResponse($response, 'Detail Terapis', 200);
    }

    public function showChild(Child $child): JsonResponse
    {
        $child->load('family.guardians');
        $response = new ChildDetailResource($child);

        return $this->successResponse($response, 'Detail Anak', 200);
    }

    public function updateAdmin(AdminUpdateRequest $request, Admin $admin): JsonResponse
    {
        $data = $request->validated();
        $this->adminService->update($data, $admin);

        return $this->successResponse([], 'Update Admin Berhasil', 200);
    }

    public function updateTherapist(TherapistUpdateRequest $request, Therapist $therapist): JsonResponse
    {
        $data = $request->validated();
        $this->therapistService->update($data, $therapist);

        return $this->successResponse([], 'Update Terapis Berhasil', 200);
    }

    public function updateChild(ChildFamilyUpdateRequest $request, Child $child): JsonResponse
    {
        $data = $request->validated();
        $this->childService->update($data, $child);
        return $this->successResponse([], 'Update Anak Berhasil', 200);
    }

    public function storeChild(StorePatientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->childService->store($data);

        return $this->successResponse([], 'Tambah Pasien Berhasil', 201);
    }

    public function destroyChild(Child $child): JsonResponse
    {
        $this->childService->destroy($child);

        return $this->successResponse(
            [],
            'Data Anak Berhasil Diarsipkan',
            200
        );
    }

    public function destroyTherapist(Therapist $therapist): JsonResponse
    {
        $this->therapistService->destroy($therapist);

        return $this->successResponse([], 'Data Terapis Berhasil Terhapus', 200);
    }

    public function destroyAdmin(Admin $admin): JsonResponse
    {
        $this->adminService->destroy($admin);

        return $this->successResponse([], 'Data Admin Berhasil Terhapus', 200);
    }
}
