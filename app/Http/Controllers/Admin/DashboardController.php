<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Services\AdminDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ResponseFormatter;

    public function __construct(
        private AdminDashboardService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => 'nullable|date'
        ]);

        $date = $validated['date'] ?? now()->toDateString();

        $data = $this->service->getDashboardData($date);

        return $this->successResponse($data, 'Dashboard Admin Stats');
    }

    public function todayTherapySchedule(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => 'nullable|date',
        ]);

        $date = $validated['date'] ?? now()->toDateString();

        $data = $this->service->getTodayTherapySchedule($date);

        return $this->successResponse($data, 'Dashboard Admin Today Schedules');
    }
}
