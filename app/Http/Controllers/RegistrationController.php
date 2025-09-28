<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\RegistrationRequest;
use App\Http\Services\RegistrationService;

/**
 * @OA\Post(
 * path="/registration",
 * operationId="storeNewFamilyRegistration",
 * tags={"Registration"},
 * summary="Pendaftaran Keluarga Baru",
 * description="Mendaftarkan satu keluarga baru (wali & anak) dan secara otomatis membuat jadwal observasi awal.",
 * @OA\RequestBody(
 * required=true,
 * description="Data lengkap pendaftaran",
 * @OA\JsonContent(ref="#/components/schemas/RegistrationRequest")
 * ),
 * @OA\Response(
 * response=201,
 * description="Pendaftaran Berhasil",
 * @OA\JsonContent(
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="message", type="string", example="Pendaftaran Berhasil"),
 * @OA\Property(property="data", type="object", example={})
 * )
 * ),
 * @OA\Response(
 * response=422,
 * description="Validation Error (misal: email sudah ada, atau data tidak valid)"
 * )
 * )
 */
class RegistrationController extends Controller
{
    use ResponseFormatter;

    protected $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }
    public function store(RegistrationRequest $request)
    {
        $data = $request->validated();
        $this->registrationService->registration($data);
        return $this->successResponse([], 'Pendaftaran Berhasil', 201);
    }
}
