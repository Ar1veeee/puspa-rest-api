<?php

namespace App\Http\Controllers\Owner_Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AdminResource;
use App\Http\Resources\ChildrenResource;
use App\Http\Resources\TherapistResource;
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
    )
    {
        $this->adminService = $adminService;
        $this->therapistService = $therapistService;
        $this->childService = $childService;
    }

    public function indexAdmin(): JsonResponse
    {
        $admins = $this->adminService->index();
        $response = AdminResource::collection($admins);

        return $this->successResponse($response, 'Daftar Semua Admin', 200);
    }

    public function indexTherapist(): JsonResponse
    {
        $therapists = $this->therapistService->index();
        $response = TherapistResource::collection($therapists);

        return $this->successResponse($response, 'Daftar Semua Terapis', 200);
    }

    public function indexChild(): JsonResponse
    {
        $children = $this->childService->getAllChild();
        $response = ChildrenResource::collection($children);

        return $this->successResponse($response, 'Daftar Semua Anak', 200);
    }
}
