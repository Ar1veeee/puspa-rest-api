<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddChildrenRequest;
use App\Http\Requests\StoreGuardianRequest;
use App\Http\Resources\ChildrenResource;
use App\Http\Services\GuardianService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{
    use ResponseFormatter;

    protected $guardianService;

    public function __construct(GuardianService $guardianService)
    {
        return $this->guardianService = $guardianService;
    }

    public function indexChildren(): JsonResponse
    {
        $userId = Auth::id();
        $children = $this->guardianService->getChildren($userId);
        $response = ChildrenResource::collection($children);

        return $this->successResponse($response, 'Daftar Anak', 200);
    }

    public function storeChild(AddChildrenRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        $this->guardianService->addChild($userId, $data);

        return $this->successResponse([], 'Tambah Anak Berhasil', 201);
    }

    public function update(StoreGuardianRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        $this->guardianService->updateGuardians($data, $userId);

        return $this->successResponse([], 'Data orang tua berhasil disimpan', 200);
    }
}
