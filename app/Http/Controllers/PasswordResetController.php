<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\PasswordResetService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class PasswordResetController extends Controller
{
    use ResponseFormatter;

    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }


    /**
     * @OA\Post(
     * path="/auth/forgot-password",
     * operationId="forgotPassword",
     * tags={"Authentication"},
     * summary="Kirim link reset password",
     * description="Mengirim email berisi link untuk mereset password pengguna.",
     * @OA\RequestBody(
     * required=true,
     * description="Email pengguna yang terdaftar",
     * @OA\JsonContent(
     * required={"email"},
     * @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Link berhasil dikirim"
     * ),
     * @OA\Response(response=404, description="Pengguna dengan email tersebut tidak ditemukan"),
     * @OA\Response(response=422, description="Email tidak valid")
     * )
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        try {
            $data = $this->passwordResetService->sendResetLinkEmail($request->email);

            return $this->successResponse(
                $data,
                'Tautan reset password telah dikirim ke email Anda.'
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Pengguna tidak ditemukan.', [], 404);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), [], 400);
        }
    }

    /**
     * @OA\Post(
     * path="/auth/resend-reset",
     * summary="Kirim ulang link reset password",
     * tags={"Authentication"}
     * )
     */
    public function resendResetLink(string $email): JsonResponse
    {
        try {
            $this->passwordResetService->resendResetLink($email);

            return $this->successResponse(
                'Link reset password baru telah dikirim. Cek email Anda.'
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Pengguna tidak ditemukan.', [], 404);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), [], 429);
        }
    }

    /**
     * @OA\Get(
     * path="/auth/resend-reset-status",
     * summary="Cek status cooldown resend reset password",
     * tags={"Authentication"}
     * )
     */
    public function checkResendStatus(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        try {
            $email = $request->email;

            $canResend = $this->passwordResetService->canResend($email);
            $remainingSeconds = $this->passwordResetService->getRemainingCooldown($email);

            return $this->successResponse(
                [
                    'can_resend' => $canResend,
                    'remaining_seconds' => $remainingSeconds,
                ],
                $canResend ? 'Anda dapat meminta ulang link reset password.' : "Tunggu {$remainingSeconds} detik lagi.",
                200
            );

        } catch (Exception $e) {
            return $this->errorResponse('Gagal mengambil status.', [], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/auth/reset-password",
     * operationId="resetPassword",
     * tags={"Authentication"},
     * summary="Reset password pengguna",
     * description="Mengatur ulang password pengguna menggunakan token dari email.",
     * @OA\RequestBody(
     * required=true,
     * description="Data untuk reset password",
     * @OA\JsonContent(ref="#/components/schemas/ResetPasswordRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Password berhasil diatur ulang"
     * ),
     * @OA\Response(response=422, description="Data tidak valid (misal: token salah, email tidak cocok, atau validasi password gagal)")
     * )
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $data = $this->passwordResetService->resetPassword(
                $request->token,
                $request->email,
                $request->password
            );

            return $this->successResponse(
                $data,
                'Password berhasil diatur ulang. Silakan login.'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), [], 422);
        }
    }
}
