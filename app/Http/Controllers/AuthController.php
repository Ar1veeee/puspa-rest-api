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

    /**
     * @OA\Post(
     * path="/auth/register",
     * operationId="registerUser",
     * tags={"Authentication"},
     * summary="Registrasi pengguna baru",
     * description="Mendaftarkan pengguna baru dan mengirimkan email verifikasi.",
     * @OA\RequestBody(
     * required=true,
     * description="Data registrasi pengguna",
     * @OA\JsonContent(ref="#/components/schemas/UserRegisterRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Registrasi berhasil",
     * @OA\JsonContent(
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Registrasi berhasil. Silakan melakukan verifikasi!"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="user_id", type="string", description="ULID dari pengguna yang baru dibuat")
     * )
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation Error"
     * )
     * )
     */
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

    /**
     * @OA\Post(
     * path="/auth/login",
     * operationId="loginUser",
     * tags={"Authentication"},
     * summary="Login pengguna",
     * description="Mengautentikasi pengguna dan mengembalikan access token.",
     * @OA\RequestBody(
     * required=true,
     * description="Kredensial login",
     * @OA\JsonContent(ref="#/components/schemas/UserLoginRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Login berhasil",
     * @OA\JsonContent(
     * @OA\Property(property="success", type="boolean", example=true),
     * @OA\Property(property="message", type="string", example="Login berhasil"),
     * @OA\Property(property="data", ref="#/components/schemas/LoginResource")
     * )
     * ),
     * @OA\Response(response=401, description="Kredensial tidak valid"),
     * @OA\Response(response=403, description="Akun belum aktif atau belum diverifikasi")
     * )
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $loginData = $this->authService->login($data);
        $response = new LoginResource($loginData);

        return $this->successResponse($response, 'Login berhasil', 200);
    }

    /**
     * @OA\Post(
     * path="/auth/logout",
     * operationId="logoutUser",
     * tags={"Authentication"},
     * summary="Logout pengguna",
     * description="Mencabut (revoke) token pengguna yang sedang login.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Logout berhasil"
     * )
     * )
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
