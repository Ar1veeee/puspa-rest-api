<?php

namespace App\Http\Controllers\Assessor_Therapist;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Services\TherapistDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ResponseFormatter;

    public function __construct(
        private TherapistDashboardService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020|max:2099'
        ]);

        $month = $validated['month'] ?? now()->month;
        $year = $validated['year'] ?? now()->year;

        $therapist = $request->user()->therapist;

        if (!$therapist) {
            return response()->json([
                'success' => false,
                'message' => 'Therapist profile not found'
            ], 404);
        }

        $data = $this->service->getDashboardData($therapist->id, $month, $year);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function upcomingSchedules(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:5', 'max:100'],
        ]);

        $therapist = $request->user()->therapist;

        if (!$therapist) {
            return $this->errorResponse(
                'Therapist profile not found',
                ['message' => ['Therapist profile tidak ditemukan']],
                404
            );
        }

        $schedules = $this->service->getUpcomingSchedulesCollection(
            $therapist->id,
            $validated['limit'] ?? 50
        );

        return $this->successResponse(
            $schedules,
            'Upcoming schedules',
            200
        );
    }
}
