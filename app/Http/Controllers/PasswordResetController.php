<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    use ResponseFormatter;

    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $response = $this->passwordResetService->sendResetLinkEmail($request->email);

        if ($response['success']) {
            return $this->successResponse($response['data'], $response['message'], $response['status']);
        } else {
            return $this->errorResponse($response['message'], $response['data'], $response['status']);
        }
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $response = $this->passwordResetService->resetPassword($data['token'], $data['email'], $data['password']);

        return $this->successResponse($response['data'], $response['message'], $response['status']);
    }
}
