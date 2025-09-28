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

        $response = $this->passwordResetService->sendResetLinkEmail($request->email);

        if ($response['success']) {
            return $this->successResponse($response['data'], $response['message'], $response['status']);
        } else {
            return $this->errorResponse($response['message'], $response['data'], $response['status']);
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
        $data = $request->validated();
        $response = $this->passwordResetService->resetPassword($data['token'], $data['email'], $data['password']);

        return $this->successResponse($response['data'], $response['message'], $response['status']);
    }
}
