<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyVerifiedException;
use App\Exceptions\RateLimitExceededException;
use App\Http\Helpers\ResponseFormatter;
use App\Models\User;
use App\Services\VerificationService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
    use ResponseFormatter;

    protected $verificationService;
    protected string $frontendUrl;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
        $this->frontendUrl = config('app.frontend_url');
    }

    public function verify(string $id, string $hash)
    {
        try {
            $this->verificationService->verifyEmail($id, $hash);
            return redirect($this->frontendUrl . '/auth/email-verify');
        } catch (ModelNotFoundException $e) {
            return redirect($this->frontendUrl . '/auth/email-verify?status=invalid');
        }
    }

    public function resendNotification(User $user): JsonResponse
    {
        try {
            $this->verificationService->resendVerificationNotification($user);

            return $this->successResponse(
                [
                    'can_resend' => false,
                    'cooldown_seconds' => VerificationService::RESEND_COOLDOWN_SECONDS,
                ],
                'Link verifikasi baru telah dikirim ke email Anda.',
                200
            );
        } catch (AlreadyVerifiedException $e) {
            return $this->errorResponse($e->getMessage(), [], 400);
        } catch (RateLimitExceededException $e) {
            return $this->errorResponse($e->getMessage(), [], 429);
        } catch (Exception $e) {
            return $this->errorResponse('Gagal mengirim email verifikasi.', [], 500);
        }
    }

    public function checkResendStatus(User $user): JsonResponse
    {
        try {
            $statusData = $this->verificationService->getResendStatus($user);

            $message = $statusData['is_verified']
                ? 'Email sudah terverifikasi.'
                : ($statusData['can_resend']
                    ? 'Anda dapat meminta link verifikasi baru.'
                    : "Tunggu {$statusData['remaining_seconds']} detik lagi.");

            return $this->successResponse($statusData, $message);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Pengguna tidak ditemukan.', [], 404);
        } catch (Exception $e) {
            return $this->errorResponse('Gagal mengambil status.', [], 500);
        }
    }
}
