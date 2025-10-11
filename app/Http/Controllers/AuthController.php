<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ResponseFormatter;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userId = $this->authService->register($data);

        return $this->successResponse(
            ['user_id' => $userId],
            'Daftar akun berhasil. Silakan melakukan verifikasi!',
            201
        );
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $loginData = $this->authService->login($data);
        $response = new LoginResource($loginData);

        return $this->successResponse($response, 'Login berhasil', 200);
    }

    public function logout(): JsonResponse
    {

        $this->authService->logout();

        return $this->successResponse([], 'Logout berhasil', 200);
    }

    public function protected(): JsonResponse
    {
        return $this->successResponse([], 'Halo Dari Proteksi', 200);
    }
}
