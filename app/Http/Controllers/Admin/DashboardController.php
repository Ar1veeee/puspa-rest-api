<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
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

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function todayTherapySchedule(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => 'nullable|date',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:5|max:100',
            'search' => 'nullable|string|max:100',
            'type' => 'nullable|in:fisio,okupasi,wicara,paedagog'
        ]);

        $date = $validated['date'] ?? now()->toDateString();
        $perPage = $validated['per_page'] ?? 15;
        $search = $validated['search'] ?? null;
        $type = $validated['type'] ?? null;

        $data = $this->service->getTodayTherapySchedule($date, $perPage, $search, $type);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
