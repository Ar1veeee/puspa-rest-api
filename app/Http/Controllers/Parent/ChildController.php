<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddChildrenRequest;
use App\Http\Requests\ChildFamilyUpdateRequest;
use App\Http\Resources\ChildDetailResource;
use App\Http\Resources\ChildrenResource;
use App\Http\Services\ChildService;
use App\Http\Services\GuardianService;
use App\Models\Child;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    use ResponseFormatter;

    protected $guardianService;
    protected $childService;

    public function __construct(
        GuardianService $guardianService,
        ChildService $childService,
    ) {
        $this->guardianService = $guardianService;
        $this->childService = $childService;
    }

    public function indexChildren(): JsonResponse
    {
        $userId = Auth::id();
        $children = $this->guardianService->getChildren($userId);
        $response = ChildrenResource::collection($children);

        return $this->successResponse($response, 'Daftar Anak', 200);
    }

    public function showChild(Child $child): JsonResponse
    {
        $child->load('family.guardians');
        $response = new ChildDetailResource($child);

        return $this->successResponse($response, 'Detail Anak', 200);
    }

    public function storeChild(AddChildrenRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        $this->guardianService->addChild($userId, $data);

        return $this->successResponse([], 'Tambah Anak Berhasil', 201);
    }

    public function updateChild(ChildFamilyUpdateRequest $request, Child $child)
    {
        $data = $request->validated();
        $this->childService->update($data, $child);
        return $this->successResponse([], 'Update Anak Berhasil', 200);
    }
}
