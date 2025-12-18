<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\RegistrationRequest;
use App\Services\RegistrationService;

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
