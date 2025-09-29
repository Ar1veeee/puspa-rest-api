<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseFormatter;
use App\Http\Resources\ChildDetailResource;
use App\Http\Resources\ChildrenResource;
use App\Http\Services\ChildService;
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

    public function show($id): JsonResponse
    {
        $child = $this->childService->getChildDetail($id);
        $response = new ChildDetailResource($child);

        return $this->successResponse($response, 'Detail Anak', 200);
    }
}
