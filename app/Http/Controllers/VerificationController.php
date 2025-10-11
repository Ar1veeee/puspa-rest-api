<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyVerifiedException;
use App\Exceptions\RateLimitExceededException;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Services\VerificationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

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
            $this->verificationService->verifyEmail($id);
            return redirect($this->frontendUrl . '/auth/email-verify');
        } catch (ModelNotFoundException $e) {
            return redirect($this->frontendUrl . '/auth/email-verify?status=invalid');
        }
    }

    public function resendNotification(string $user_id): JsonResponse
    {
        try {
            $this->verificationService->resendVerificationNotification($user_id);

            return $this->successResponse(
                [
                    'can_resend' => false,
                    'cooldown_seconds' => VerificationService::RESEND_COOLDOWN_SECONDS,
                ],
                'Link verifikasi baru telah dikirim ke email Anda.',
                200
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Pengguna tidak ditemukan.', [], 404);
        } catch (AlreadyVerifiedException $e) {
            return $this->errorResponse($e->getMessage(), [], 400);
        } catch (RateLimitExceededException $e) {
            return $this->errorResponse($e->getMessage(), [], 429);
        } catch (Exception $e) {
            return $this->errorResponse('Gagal mengirim email verifikasi.', [], 500);
        }
    }

    public function checkResendStatus(string $user_id): JsonResponse
    {
        try {
            $statusData = $this->verificationService->getResendStatus($user_id);

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
