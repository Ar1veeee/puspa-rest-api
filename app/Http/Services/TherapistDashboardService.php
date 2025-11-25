<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TherapistDashboardService
{
    public function getDashboardData(string $therapistId, int $month, int $year): array
    {
        $currentPeriod = Carbon::create($year, $month, 1);

        return [
            'period' => [
                'month' => $month,
                'year' => $year,
                'month_name' => $currentPeriod->translatedFormat('F Y'),
            ],
            'metrics' => [
                'total_observations' => $this->getTotalObservations($therapistId, $month, $year),
                'total_therapists' => $this->getTotalTherapists($month, $year),
                'completion_rate' => $this->getCompletionRate($therapistId, $month, $year),
                'total_assessors' => $this->getTotalAssessors($month, $year),
            ],
            'patient_categories' => $this->getPatientCategories($therapistId, $month, $year),
            'trend_chart' => $this->getTrendChart($therapistId, $month, $year),
        ];
    }

    private function getTotalObservations(string $therapistId, int $month, int $year): array
    {
        $current = DB::table('observations')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $previous = DB::table('observations')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month - 1 ?: 12)
            ->count();

        return $this->calculateChange($current, $previous);
    }

    private function getTotalTherapists(int $month, int $year): array
    {
        // Total terapis yang aktif handle observasi/assessment di periode ini
        $current = DB::table('observations')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('therapist_id')
            ->distinct('therapist_id')
            ->count();

        $previous = DB::table('observations')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month - 1 ?: 12)
            ->whereNotNull('therapist_id')
            ->distinct('therapist_id')
            ->count();

        return $this->calculateChange($current, $previous);
    }

    private function getCompletionRate(string $therapistId, int $month, int $year): array
    {
        // Completion rate dari assessment yang di-handle terapis ini
        $assessments = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        $total = $assessments->count();
        $completed = (clone $assessments)->where('status', 'completed')->count();

        $currentRate = $total > 0 ? round(($completed / $total) * 100, 0) : 0;

        // Previous month
        $prevAssessments = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month - 1 ?: 12);

        $prevTotal = $prevAssessments->count();
        $prevCompleted = (clone $prevAssessments)->where('status', 'completed')->count();
        $previousRate = $prevTotal > 0 ? round(($prevCompleted / $prevTotal) * 100, 0) : 0;

        return $this->calculateChange($currentRate, $previousRate, true);
    }

    private function getTotalAssessors(int $month, int $year): array
    {
        // Total admin yang assign assessment di periode ini
        $current = DB::table('assessment_details')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('admin_id')
            ->distinct('admin_id')
            ->count();

        $previous = DB::table('assessment_details')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month - 1 ?: 12)
            ->whereNotNull('admin_id')
            ->distinct('admin_id')
            ->count();

        return $this->calculateChange($current, $previous);
    }

    private function getPatientCategories(string $therapistId, int $month, int $year): array
    {
        $categories = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->select('ad.type', DB::raw('COUNT(DISTINCT a.child_id) as count'))
            ->where('ad.therapist_id', $therapistId)
            ->whereYear('a.created_at', $year)
            ->whereMonth('a.created_at', $month)
            ->groupBy('ad.type')
            ->get();

        $total = $categories->sum('count');

        $mapping = [
            'fisio' => 'Fisioterapi',
            'okupasi' => 'Okupasi',
            'wicara' => 'Wicara',
            'paedagog' => 'Paedagog'
        ];

        return $categories->map(function ($category) use ($total, $mapping) {
            return [
                'type' => $mapping[$category->type] ?? ucfirst($category->type),
                'count' => $category->count,
                'percentage' => $total > 0 ? round(($category->count / $total) * 100, 1) : 0
            ];
        })->sortByDesc('percentage')->values()->toArray();
    }

    private function getTrendChart(string $therapistId, int $month, int $year): array
    {
        // Data untuk chart: Total Anak, Kategori Anak, Total Observasi, Total Assessment
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Total Anak (unique children handled)
        $totalAnak = DB::table('observations as o')
            ->where('o.therapist_id', $therapistId)
            ->whereDate('o.created_at', '<=', $endDate)
            ->distinct('o.child_id')
            ->count();

        // Kategori Anak (by therapy type)
        $kategoriAnak = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->where('ad.therapist_id', $therapistId)
            ->whereYear('a.created_at', $year)
            ->whereMonth('a.created_at', $month)
            ->distinct('a.child_id')
            ->count();

        // Total Observasi
        $totalObservasi = DB::table('observations')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        // Total Assessment
        $totalAssessment = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        return [
            ['label' => 'Total Anak', 'value' => $totalAnak],
            ['label' => 'Kategori Anak', 'value' => $kategoriAnak],
            ['label' => 'Total Observasi', 'value' => $totalObservasi],
            ['label' => 'Total Assessment', 'value' => $totalAssessment],
        ];
    }

    public function getUpcomingObservations(string $therapistId, int $perPage)
    {
        $query = DB::table('observations as o')
            ->join('children as c', 'o.child_id', '=', 'c.id')
            ->leftJoin('assessments as a', 'o.id', '=', 'a.observation_id')
            ->select(
                'o.id',
                'c.child_name as nama_pasien',
                DB::raw("CASE
                    WHEN a.id IS NOT NULL THEN 'Assessment'
                    ELSE 'Observasi'
                END as jenis_layanan"),
                'o.status',
                DB::raw("COALESCE(o.scheduled_date, o.created_at) as tanggal"),
                DB::raw("TIME_FORMAT(o.completed_at, '%H:%i') as waktu")
            )
            ->where('o.therapist_id', $therapistId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('o.created_at', 'desc');

        return $query->paginate($perPage);
    }

    private function calculateChange(float $current, float $previous, bool $isPercentage = false): array
    {
        $change = $previous > 0
            ? round((($current - $previous) / $previous) * 100, 2)
            : ($current > 0 ? 100 : 0);

        return [
            'current' => $isPercentage ? $current : (int)$current,
            'previous' => $isPercentage ? $previous : (int)$previous,
            'change_percent' => abs($change),
            'change_direction' => $change >= 0 ? 'increase' : 'decrease',
            'trend' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable'),
        ];
    }
}
