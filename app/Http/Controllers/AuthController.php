<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Services\AuthService;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ResponseFormatter;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="string", description="User ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors"
     *     )
     * )
     *
     * @param UserRegisterRequest $request
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userId = $this->authService->register($data);

        return $this->successResponse(
            ['user_id' => $userId],
            'Registrasi berhasil. Silakan melakukan verifikasi!',
            201
        );
    }

    /**
     * Login user and return token.
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Login user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserLoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(ref="#/components/schemas/LoginResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Account not active"
     *     )
     * )
     *
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $loginData = $this->authService->login($data);
        $resourceData = new LoginResource((object) $loginData);

        return $this->successResponse($resourceData, 'Login berhasil', 200);
    }

    /**
     * Logout user (Revoke the token).
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Logout user",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout"
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {

        $this->authService->logout();

        return $this->successResponse([], 'Logout berhasil', 200);
    }

    /**
     * Protected route example.
     * @OA\Get(
     *     path="/auth/protected",
     *     summary="Protected route",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful"
     *     )
     * )
     * @return JsonResponse
     */
    public function protected(): JsonResponse
    {
        return $this->successResponse([], 'Halo Dari Proteksi', 200);
    }
}
