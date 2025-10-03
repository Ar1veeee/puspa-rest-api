<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AdminsUnverifiedResource;
use App\Http\Services\OwnerService;
use App\Http\Services\VerificationService;
use Illuminate\Http\JsonResponse;

class OwnerController extends Controller
{
    use ResponseFormatter;

    protected $ownerService;
    protected $verificationService;

    public function __construct(OwnerService $ownerService, VerificationService $verificationService)
    {
        $this->ownerService = $ownerService;
        $this->verificationService = $verificationService;
    }

    public function indexAdmin(): JsonResponse
    {
        $adminsUnverified = $this->ownerService->getAllAdminUnverified();
        $response = AdminsUnverifiedResource::collection($adminsUnverified);

        return $this->successResponse($response, 'Daftar Admin Belum Terverifikasi', 200);
    }

    public function indexTherapist(): JsonResponse
    {
        $therapistsUnverified = $this->ownerService->getAllTherapistUnverified();
        $response = AdminsUnverifiedResource::collection($therapistsUnverified);

        return $this->successResponse($response, 'Daftar Terapis Belum Terverifikasi', 200);
    }

    public function activateAccount($id): JsonResponse
    {
        $this->ownerService->activateAccount($id);
        return $this->successResponse([], 'Akun berhasil diaktifkan', 200);
    }

}
