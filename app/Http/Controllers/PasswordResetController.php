<?php

namespace App\Http\Controllers;

use App\Exceptions\RateLimitExceededException;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResendResetLinkRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\PasswordResetService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class PasswordResetController extends Controller
{
    use ResponseFormatter;

    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $data = $this->passwordResetService->sendResetLinkEmail($request->validated()['email']);
            return $this->successResponse($data, 'Tautan reset password telah dikirim ke email Anda.');
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Pengguna tidak ditemukan.', [], 404);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), [], 400);
        }
    }

    public function resendResetLink(ResendResetLinkRequest $request): JsonResponse
    {
        try {
            $this->passwordResetService->resendResetLink($request->validated()['email']);
            return $this->successResponse(null, 'Link reset password baru telah dikirim. Cek email Anda.');
        } catch (RateLimitExceededException|Exception $e) {
            return $this->errorResponse($e->getMessage(), [], 429);
        }
    }

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
