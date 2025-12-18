<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddChildrenRequest;
use App\Http\Requests\ChildFamilyUpdateRequest;
use App\Http\Resources\ChildDetailResource;
use App\Http\Resources\ChildrenResource;
use App\Models\Child;
use App\Services\ChildService;
use App\Services\GuardianService;
use Illuminate\Http\JsonResponse;

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
        $children = auth()->user()
            ->guardian
            ->family
            ->children()
            ->get();

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
        $guardian = $request->user()->guardian;

        $data = $request->validated();

        $this->guardianService->addChild($guardian, $data);

        return $this->successResponse([], 'Tambah Anak Berhasil', 201);
    }

    public function updateChild(ChildFamilyUpdateRequest $request, Child $child): JsonResponse
    {
        $data = $request->validated();
        $this->childService->update($data, $child);
        return $this->successResponse([], 'Update Anak Berhasil', 200);
    }

    public function destroyChild(Child $child): JsonResponse
    {
        $this->childService->destroy($child);

        return $this->successResponse(
            [],
            'Data Anak Berhasil Diarsipkan',
            200
        );
    }
}
