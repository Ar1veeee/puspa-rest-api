<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\OwnerDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private OwnerDashboardService $dashboardService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020|max:2099'
        ]);

        $month = $validated['month'] ?? now()->month;
        $year = $validated['year'] ?? now()->year;

        $data = $this->dashboardService->getDashboardData($month, $year);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
