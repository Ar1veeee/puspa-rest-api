<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\StoreGuardianRequest;
use App\Http\Services\GuardianService;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{
    use ResponseFormatter;

    protected $guardianService;

    public function __construct(GuardianService $guardianService)
    {
        return $this->guardianService = $guardianService;
    }

    public function store(StoreGuardianRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        $this->guardianService->updateGuardians($data, $userId);

        return $this->successResponse([], 'Data orang tua berhasil disimpan', 200);
    }
}
