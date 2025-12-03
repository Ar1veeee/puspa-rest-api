<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\AdminsUnverifiedResource;
use App\Http\Resources\TherapistUnverifiedResource;
use App\Http\Services\OwnerService;
use App\Http\Services\VerificationService;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    use ResponseFormatter;

    protected $ownerService;
    protected $verificationService;

    public function __construct(OwnerService $ownerService, VerificationService $verificationService)
    {
        $this->ownerService = $ownerService;
        $this->verificationService = $verificationService;
    }

    public function indexUnverified(string $type): JsonResponse
    {
        $valid_type = ['admin', 'therapist'];
        if (!in_array($type, $valid_type)) {
            return $this->errorResponse('Bad Request', [
                'error' => 'Tipe tidak valid'
            ], 400);
        }

        if ($type === 'admin') {
            $adminsUnverified = $this->ownerService->getAllAdminUnverified();
            $response = AdminsUnverifiedResource::collection($adminsUnverified);
            $message = 'Daftar Admin Belum Terverifikasi';
        } else if ($type === 'therapist') {
            $therapistsUnverified = $this->ownerService->getAllTherapistUnverified();
            $response = TherapistUnverifiedResource::collection($therapistsUnverified);
            $message = 'Daftar Therapis Belum Terverifikasi';
        }

        return $this->successResponse($response, $message, 200);
    }

    public function promoteToAssessor(User $user)
    {
        $this->ownerService->promoteToAssessor($user);
        return $this->successResponse([], 'Terapis Berhasil Ditetaapkan Sebagai Asesor', 200);
    }

    public function activateAccount(User $user): JsonResponse
    {
        $this->ownerService->activateAccount($user);
        return $this->successResponse([], 'Akun berhasil diaktifkan', 200);
    }
    
    public function deleteAccount(User $user): JsonResponse
    {
        $this->ownerService->deleteAccount($user);
        return $this->successResponse([], 'Akun berhasil dihapus', 200);
    }
}
