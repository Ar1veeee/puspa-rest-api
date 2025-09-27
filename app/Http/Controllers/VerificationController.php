<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Services\VerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use ResponseFormatter;

    protected $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function verify(string $id): JsonResponse
    {
        $this->verificationService->verifyEmail($id);

        return $this->successResponse([], 'Email berhasil diverifikasi. Silakan login.', 200);
    }

    public function resendNotification(Request $request): JsonResponse
    {
        $request->validate(['user_id' => 'required|string']);
        $userId = $request->query('user_id');

        $response = $this->verificationService->resendVerificationNotification($userId);

        return $this->successResponse($response['data'], $response['message'], $response['status']);
    }
}
