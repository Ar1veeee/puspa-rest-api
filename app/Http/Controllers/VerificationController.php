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

    /**
     * @OA\Get(
     * path="/email/verify/{id}/{hash}",
     * operationId="verifyEmail",
     * tags={"Email Verification"},
     * summary="Verifikasi alamat email pengguna",
     * description="Endpoint ini diakses dari link yang dikirim ke email pengguna. Memerlukan signature yang valid.",
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     * @OA\Parameter(name="hash", in="path", required=true, @OA\Schema(type="string")),
     * @OA\Parameter(name="expires", in="query", required=true, @OA\Schema(type="integer")),
     * @OA\Parameter(name="signature", in="query", required=true, @OA\Schema(type="string")),
     * @OA\Response(response=200, description="Email berhasil diverifikasi"),
     * @OA\Response(response=400, description="Tautan tidak valid atau kadaluwarsa"),
     * @OA\Response(response=404, description="Pengguna tidak ditemukan")
     * )
     */
    public function verify(string $id): JsonResponse
    {
        $this->verificationService->verifyEmail($id);

        return $this->successResponse([], 'Email berhasil diverifikasi. Silakan login.', 200);
    }

    /**
     * @OA\Post(
     * path="/email/resend-verification",
     * operationId="resendVerification",
     * tags={"Email Verification"},
     * summary="Kirim ulang email verifikasi",
     * description="Mengirim ulang email verifikasi ke pengguna yang sedang login.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=202, description="Link baru berhasil dikirim"),
     * @OA\Response(response=200, description="Email sudah terverifikasi sebelumnya"),
     * @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function resendNotification(Request $request): JsonResponse
    {
        $request->validate(['user_id' => 'required|string']);
        $userId = $request->query('user_id');

        $response = $this->verificationService->resendVerificationNotification($userId);

        return $this->successResponse($response['data'], $response['message'], $response['status']);
    }
}
