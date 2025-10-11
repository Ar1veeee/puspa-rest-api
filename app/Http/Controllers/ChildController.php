<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\ChildDetailResource;
use App\Http\Resources\ChildrenResource;
use App\Http\Services\ChildService;
use App\Models\Child;
use Illuminate\Http\JsonResponse;

class ChildController extends Controller
{
    use ResponseFormatter;

    protected $childService;

    public function __construct(ChildService $childService)
    {
        $this->childService = $childService;
    }

    public function index(): JsonResponse
    {
        $children = $this->childService->getAllChild();
        $response = ChildrenResource::collection($children);

        return $this->successResponse($response, 'Daftar Semua Anak', 200);
    }

    public function show(Child $child): JsonResponse
    {
        $child->load('family.guardians');
        $response = new ChildDetailResource($child);

        return $this->successResponse($response, 'Detail Anak', 200);
    }
}
