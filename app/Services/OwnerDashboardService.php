<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OwnerDashboardService
{
    public function getDashboardData(int $month, int $year): array
    {
        $currentPeriod = Carbon::create($year, $month, 1);
        $previousPeriod = $currentPeriod->copy()->subMonth();

        return [
            'period' => [
                'month' => $month,
                'year' => $year,
                'month_name' => $currentPeriod->translatedFormat('F'),
            ],
            'metrics' => [
                'total_observations' => $this->getTotalObservations($currentPeriod, $previousPeriod),
                'total_assessments' => $this->getTotalAssessments($currentPeriod, $previousPeriod),
                'completion_rate' => $this->getCompletionRate($currentPeriod, $previousPeriod),
                'unanswered_questions' => $this->getUnansweredQuestions($currentPeriod, $previousPeriod),
            ],
            'historical_trend' => $this->getHistoricalTrend($month, $year),
            'patient_categories' => $this->getPatientCategories($month, $year),
        ];
    }

    private function getTotalObservations(Carbon $current, Carbon $previous): array
    {
        $currentCount = DB::table('observations')
            ->whereYear('created_at', $current->year)
            ->whereMonth('created_at', $current->month)
            ->count();

        $previousCount = DB::table('observations')
            ->whereYear('created_at', $previous->year)
            ->whereMonth('created_at', $previous->month)
            ->count();

        return $this->calculateMetric($currentCount, $previousCount);
    }

    private function getTotalAssessments(Carbon $current, Carbon $previous): array
    {
        $currentCount = DB::table('assessments')
            ->whereYear('created_at', $current->year)
            ->whereMonth('created_at', $current->month)
            ->count();

        $previousCount = DB::table('assessments')
            ->whereYear('created_at', $previous->year)
            ->whereMonth('created_at', $previous->month)
            ->count();

        return $this->calculateMetric($currentCount, $previousCount);
    }

    private function getCompletionRate(Carbon $current, Carbon $previous): array
    {
        $currentTotal = DB::table('assessment_details')
            ->whereYear('created_at', $current->year)
            ->whereMonth('created_at', $current->month)
            ->count();

        $currentCompleted = DB::table('assessment_details')
            ->whereYear('created_at', $current->year)
            ->whereMonth('created_at', $current->month)
            ->where('status', 'completed')
            ->count();

        $currentRate = $currentTotal > 0
            ? round(($currentCompleted / $currentTotal) * 100, 2)
            : 0;

        $previousTotal = DB::table('assessment_details')
            ->whereYear('created_at', $previous->year)
            ->whereMonth('created_at', $previous->month)
            ->count();

        $previousCompleted = DB::table('assessment_details')
            ->whereYear('created_at', $previous->year)
            ->whereMonth('created_at', $previous->month)
            ->where('status', 'completed')
            ->count();

        $previousRate = $previousTotal > 0
            ? round(($previousCompleted / $previousTotal) * 100, 2)
            : 0;

        return $this->calculateMetric($currentRate, $previousRate, true);
    }

    private function getUnansweredQuestions(Carbon $current, Carbon $previous): array
    {
        $currentCount = DB::table('assessment_answers as aa')
            ->join('assessment_details as ad', 'aa.assessment_detail_id', '=', 'ad.id')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->whereYear('a.created_at', $current->year)
            ->whereMonth('a.created_at', $current->month)
            ->whereNull('aa.answer_value')
            ->count();

        $previousCount = DB::table('assessment_answers as aa')
            ->join('assessment_details as ad', 'aa.assessment_detail_id', '=', 'ad.id')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->whereYear('a.created_at', $previous->year)
            ->whereMonth('a.created_at', $previous->month)
            ->whereNull('aa.answer_value')
            ->count();

        return $this->calculateMetric($currentCount, $previousCount);
    }

    private function getHistoricalTrend(int $month, int $year): array
    {
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        $startDate = $endDate->copy()->subMonths(3)->startOfMonth();

        $observations = DB::table('observations')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('period')
            ->orderBy('period')
            ->pluck('count', 'period');

        $assessments = DB::table('assessments')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('period')
            ->orderBy('period')
            ->pluck('count', 'period');

        $completions = DB::table('assessment_details')
            ->selectRaw('DATE_FORMAT(completed_at, "%Y-%m") as period, COUNT(*) as count')
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('period')
            ->orderBy('period')
            ->pluck('count', 'period');

        $assessors = DB::table('assessment_details')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(DISTINCT therapist_id) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('therapist_id')
            ->groupBy('period')
            ->orderBy('period')
            ->pluck('count', 'period');

        return [
            [
                'stage' => 'Observasi',
                'data' => $this->normalizeHistoricalData($observations, $startDate, $endDate)
            ],
            [
                'stage' => 'Assessment',
                'data' => $this->normalizeHistoricalData($assessments, $startDate, $endDate)
            ],
            [
                'stage' => 'Penyelesaian',
                'data' => $this->normalizeHistoricalData($completions, $startDate, $endDate)
            ],
            [
                'stage' => 'Asesor',
                'data' => $this->normalizeHistoricalData($assessors, $startDate, $endDate)
            ],
        ];
    }

    private function normalizeHistoricalData($data, Carbon $start, Carbon $end): array
    {
        $result = [];
        $current = $start->copy();

        while ($current <= $end) {
            $key = $current->format('Y-m');
            $result[] = [
                'period' => $current->translatedFormat('M Y'),
                'value' => $data[$key] ?? 0
            ];
            $current->addMonth();
        }

        return $result;
    }

    private function getPatientCategories(int $month, int $year): array
    {
        $categories = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->select('ad.type', DB::raw('COUNT(DISTINCT a.child_id) as count'))
            ->whereYear('a.created_at', $year)
            ->whereMonth('a.created_at', $month)
            ->groupBy('ad.type')
            ->get();

        $total = $categories->sum('count');

        return $categories->map(function ($category) use ($total) {
            return [
                'type' => ucfirst($category->type),
                'count' => $category->count,
                'percentage' => $total > 0 ? round(($category->count / $total) * 100, 1) : 0
            ];
        })->sortByDesc('percentage')->values()->toArray();
    }

    private function calculateMetric(float $current, float $previous, bool $isPercentage = false): array
    {
        $change = $previous > 0
            ? round((($current - $previous) / $previous) * 100, 2)
            : 0;

        $trend = $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable');

        return [
            'current' => $isPercentage ? $current : (int) $current,
            'previous' => $isPercentage ? $previous : (int) $previous,
            'change_percent' => abs($change),
            'change_direction' => $change >= 0 ? 'increase' : 'decrease',
            'trend' => $trend,
            'formatted_change' => ($change >= 0 ? '+' : '') . $change . '%'
        ];
    }
}
