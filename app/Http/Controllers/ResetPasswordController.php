<?php

namespace App\Http\Controllers;

use App\Exceptions\RateLimitExceededException;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\ResetPasswordService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class ResetPasswordController extends Controller
{
    use ResponseFormatter;

    protected $passwordResetService;

    public function __construct(ResetPasswordService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->passwordResetService->sendResetLinkEmail($request->email);

        return $this->successResponse(
            null,
            'Tautan reset password telah dikirim ke email Anda.'
        );
    }

    public function resendResetLink(ForgotPasswordRequest $request): JsonResponse
    {
        $this->passwordResetService->resendResetLink($request->email);

        return $this->successResponse(
            null,
            'Link reset password baru telah dikirim.'
        );
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
