<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Services\ParentDashboardService;
use App\Http\Resources\ParentDashboardStatsResource;
use App\Http\Resources\ParentUpcomingScheduleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ResponseFormatter;

    public function __construct(
        private ParentDashboardService $dashboardService
    ) {}

    /**
     * Get dashboard statistics
     */
    public function index(): JsonResponse
    {
        $guardian = auth()->user()->guardian;

        if (!$guardian) {
            return $this->errorResponse(
                'Guardian not found',
                ['message' => ['Guardian profile tidak ditemukan']],
                404
            );
        }

        $stats = $this->dashboardService->getStats($guardian->family_id);

        return $this->successResponse(
            new ParentDashboardStatsResource($stats),
            'Dashboard statistics',
            200
        );
    }

    /**
     * Get chart data for trend visualization
     */
    public function chartData(): JsonResponse
    {
        $guardian = auth()->user()->guardian;

        if (!$guardian) {
            return $this->errorResponse(
                'Guardian not found',
                ['message' => ['Guardian profile tidak ditemukan']],
                404
            );
        }

        $chartData = $this->dashboardService->getChartData($guardian->family_id);

        return $this->successResponse(
            $chartData,
            'Chart data',
            200
        );
    }

    /**
     * Get upcoming schedules
     */
    public function upcomingSchedules(Request $request): JsonResponse
    {
        $guardian = auth()->user()->guardian;

        if (!$guardian) {
            return $this->errorResponse(
                'Guardian not found',
                ['message' => ['Guardian profile tidak ditemukan']],
                404
            );
        }

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', 'string', 'in:all,observation,assessment'],
        ]);

        $schedules = $this->dashboardService->getUpcomingSchedules(
            $guardian->family_id,
            $validated
        );

        return $this->successResponse(
            ParentUpcomingScheduleResource::collection($schedules),
            'Upcoming schedules',
            200
        );
    }
}
