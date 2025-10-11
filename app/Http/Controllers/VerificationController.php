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

    /**
     * @OA\Get(
     * path="/email/verify/{id}/{hash}",
     * operationId="verifyEmail",
     * tags={"Email Verification"},
     * summary="Verifikasi alamat email pengguna",
     * description="Endpoint ini diakses dari link yang dikirim ke email pengguna. Memerlukan signature yang valid.",
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string"), description="User ID"),
     * @OA\Parameter(name="hash", in="path", required=true, @OA\Schema(type="string"), description="Email hash"),
     * @OA\Parameter(name="expires", in="query", required=false, @OA\Schema(type="integer"), description="Expiration timestamp"),
     * @OA\Parameter(name="signature", in="query", required=false, @OA\Schema(type="string"), description="URL signature"),
     * @OA\Response(
     *     response=302,
     *     description="Redirect ke frontend dengan status",
     *     @OA\Header(header="Location", @OA\Schema(type="string"), description="Frontend URL")
     * ),
     * @OA\Response(response=400, description="Tautan tidak valid atau kadaluarsa"),
     * @OA\Response(response=404, description="Pengguna tidak ditemukan")
     * )
     */
    public function verify(string $id, string $hash)
    {
        try {
            $this->verificationService->verifyEmail($id);
            return redirect($this->frontendUrl . '/auth/email-verify');
        } catch (ModelNotFoundException $e) {
            return redirect($this->frontendUrl . '/auth/email-verify?status=invalid');
        }
    }

    /**
     * @OA\Post(
     * path="/email/resend-verification",
     * operationId="resendVerification",
     * tags={"Email Verification"},
     * summary="Kirim ulang email verifikasi",
     * description="Mengirim ulang email verifikasi ke pengguna yang sedang login. Memiliki rate limiting 2 menit per request dan maksimal 5 request per jam.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     *     response=200,
     *     description="Link verifikasi berhasil dikirim atau email sudah terverifikasi",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="message", type="string", example="Link verifikasi baru telah dikirim ke email Anda"),
     *         @OA\Property(property="data", type="object")
     *     )
     * ),
     * @OA\Response(
     *     response=429,
     *     description="Terlalu banyak request - Rate limit exceeded",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=false),
     *         @OA\Property(property="message", type="string", example="Mohon tunggu 2 menit sebelum meminta lagi"),
     *         @OA\Property(property="errors", type="object",
     *             @OA\Property(property="can_resend", type="boolean", example=false),
     *             @OA\Property(property="remaining_seconds", type="integer", example=120)
     *         )
     *     )
     * ),
     * @OA\Response(
     *     response=400,
     *     description="Bad request - Gagal mengirim email",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=false),
     *         @OA\Property(property="message", type="string", example="Gagal mengirim email verifikasi"),
     *         @OA\Property(property="errors", type="object")
     *     )
     * ),
     * @OA\Response(response=401, description="Unauthenticated"),
     * @OA\Response(response=404, description="Pengguna tidak ditemukan")
     * )
     */
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


    /**
     * @OA\Get(
     * path="/email/resend-status",
     * operationId="checkResendStatus",
     * tags={"Email Verification"},
     * summary="Cek status cooldown resend verification",
     * description="Mengecek apakah user dapat meminta ulang email verifikasi atau masih dalam cooldown period.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     *     response=200,
     *     description="Status cooldown berhasil diambil",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="message", type="string", example="Status berhasil diambil"),
     *         @OA\Property(property="data", type="object",
     *             @OA\Property(property="can_resend", type="boolean", example=false),
     *             @OA\Property(property="remaining_seconds", type="integer", example=95),
     *             @OA\Property(property="is_verified", type="boolean", example=false)
     *         )
     *     )
     * ),
     * @OA\Response(response=401, description="Unauthenticated")
     * )
     */
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
