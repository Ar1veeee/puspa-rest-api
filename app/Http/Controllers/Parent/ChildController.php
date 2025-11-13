<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddChildrenRequest;
use App\Http\Resources\ChildrenResource;
use App\Http\Services\GuardianService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
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
}
