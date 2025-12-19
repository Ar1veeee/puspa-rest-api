<?php

namespace App\Services;

use App\Models\AssessmentDetail;
use App\Models\Observation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TherapistDashboardService
{
    public function getDashboardData(int $month, int $year): array
    {
        $currentPeriod = Carbon::create($year, $month, 1);

        return [
            'period' => [
                'month' => $month,
                'year' => $year,
                'month_name' => $currentPeriod->translatedFormat('F Y'),
            ],
            'metrics' => [
                'total_observations' => $this->getTotalObservations($month, $year),
                'total_assessments'  => $this->getTotalAssessments($month, $year),
                'total_therapists'   => $this->getTotalTherapists(),
                'completion_rate'    => $this->getCompletionRate($month, $year),
                'total_assessors'    => $this->getTotalAssessors(),
            ],
            'patient_categories' => $this->getPatientCategories(),
            'trend_chart'        => $this->getTrendChart($month, $year),
        ];
    }

    private function getTotalObservations(int $month, int $year): array
    {
        $current = Observation::whereNotNull('scheduled_date')
            ->whereYear('scheduled_date', $year)
            ->whereMonth('scheduled_date', $month)
            ->count();

        [$prevMonth, $prevYear] = $this->getPreviousMonthYear($month, $year);

        $previous = Observation::whereNotNull('scheduled_date')
            ->whereYear('scheduled_date', $prevYear)
            ->whereMonth('scheduled_date', $prevMonth)
            ->count();

        return $this->calculateChange($current, $previous);
    }

    private function getTotalAssessments(int $month, int $year): array
    {
        $current = AssessmentDetail::whereNotNull('scheduled_date')
            ->whereYear('scheduled_date', $year)
            ->whereMonth('scheduled_date', $month)
            ->count();

        [$prevMonth, $prevYear] = $this->getPreviousMonthYear($month, $year);

        $previous = AssessmentDetail::whereNotNull('scheduled_date')
            ->whereYear('scheduled_date', $prevYear)
            ->whereMonth('scheduled_date', $prevMonth)
            ->count();

        return $this->calculateChange($current, $previous);
    }

    private function getTotalTherapists(): array
    {
        $current = DB::table('therapists')->count();
        $previous = $current;
        return $this->calculateChange($current, $previous);
    }

    private function getTotalAssessors(): array
    {
        $current = DB::table('therapists')->count();
        $previous = $current;
        return $this->calculateChange($current, $previous);
    }

    private function getCompletionRate(int $month, int $year): array
    {
        $query = AssessmentDetail::whereNotNull('scheduled_date')
            ->whereYear('scheduled_date', $year)
            ->whereMonth('scheduled_date', $month);

        $total = (clone $query)->count();
        $completed = (clone $query)->where('status', 'completed')->count();
        $currentRate = $total > 0 ? round(($completed / $total) * 100) : 0;

        [$prevMonth, $prevYear] = $this->getPreviousMonthYear($month, $year);

        $prevQuery = AssessmentDetail::whereNotNull('scheduled_date')
            ->whereYear('scheduled_date', $prevYear)
            ->whereMonth('scheduled_date', $prevMonth);

        $prevTotal = (clone $prevQuery)->count();
        $prevCompleted = (clone $prevQuery)->where('status', 'completed')->count();
        $previousRate = $prevTotal > 0 ? round(($prevCompleted / $prevTotal) * 100) : 0;

        return $this->calculateChange($currentRate, $previousRate, true);
    }

    private function getPatientCategories(): array
    {
        $categories = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->select('ad.type', DB::raw('COUNT(DISTINCT a.child_id) as count'))
            ->whereNotNull('ad.scheduled_date')
            ->groupBy('ad.type')
            ->get();

        if ($categories->isEmpty()) {
            return [];
        }

        $total = $categories->sum('count');

        $mapping = [
            'fisio'    => 'Fisioterapi',
            'okupasi'  => 'Terapi Okupasi',
            'wicara'   => 'Terapi Wicara',
            'paedagog' => 'Paedagogik',
        ];

        return $categories->map(function ($cat) use ($total, $mapping) {
            return [
                'type'       => $mapping[$cat->type] ?? ucwords(str_replace('_', ' ', $cat->type)),
                'count'      => (int) $cat->count,
                'percentage' => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0,
            ];
        })
            ->sortByDesc('count')
            ->values()
            ->toArray();
    }

    private function getTrendChart(int $month, int $year): array
    {
        $baseQuery = function ($table, $dateColumn = 'scheduled_date') use ($month, $year) {
            return DB::table($table)
                ->whereNotNull($dateColumn)
                ->whereYear($dateColumn, $year)
                ->whereMonth($dateColumn, $month);
        };

        $totalObservations = $baseQuery('observations')->count();

        $totalUniqueChildrenObs = $baseQuery('observations')
            ->distinct('child_id')
            ->count('child_id');

        $totalUniqueChildrenAss = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->whereNotNull('ad.scheduled_date')
            ->whereYear('ad.scheduled_date', $year)
            ->whereMonth('ad.scheduled_date', $month)
            ->distinct('a.child_id')
            ->count('a.child_id');

        $totalAssessments = $baseQuery('assessment_details')->count();

        return [
            ['label' => 'Total Anak (Observasi)', 'value' => $totalUniqueChildrenObs],
            ['label' => 'Kategori Anak (Assessment)', 'value' => $totalUniqueChildrenAss],
            ['label' => 'Total Observasi', 'value' => $totalObservations],
            ['label' => 'Total Assessment', 'value' => $totalAssessments],
        ];
    }

    private function getPreviousMonthYear(int $month, int $year): array
    {
        return $month === 1 ? [12, $year - 1] : [$month - 1, $year];
    }

    private function calculateChange(int $current, int $previous, bool $isPercentage = false): array
    {
        if ($previous == 0) {
            $changePercent = $current > 0 ? 100 : 0;
        } else {
            $changePercent = round((($current - $previous) / $previous) * 100);
        }

        $change = $current - $previous;

        return [
            'current'          => $isPercentage ? $current . '%' : $current,
            'previous'         => $isPercentage ? $previous . '%' : $previous,
            'change_percent'   => abs($changePercent),
            'change_direction' => $change >= 0 ? 'increase' : 'decrease',
            'trend'            => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable'),
        ];
    }

    public function getUpcomingSchedulesCollection(int $limit = 50)
    {
        $observations = Observation::with('child:id,child_name')
            ->where('status', 'scheduled')
            ->where('scheduled_date', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('scheduled_date')
            ->limit($limit)
            ->get();

        $assessments = AssessmentDetail::with('assessment.child:id,child_name')
            ->where('status', 'scheduled')
            ->where('scheduled_date', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('scheduled_date')
            ->limit($limit)
            ->get();

        $allSchedules = collect();

        foreach ($observations as $obs) {
            $allSchedules->push([
                'id' => $obs->id,
                'child_id' => $obs->child?->id ?? 'unknown',
                'child_name' => $obs->child?->child_name ?? 'No Child',
                'type_label' => 'Observasi',
                'status' => ucfirst($obs->status),
                'scheduled_date' => $obs->scheduled_date,
                'date' => Carbon::parse($obs->scheduled_date)->format('d/m/Y'),
                'time' => Carbon::parse($obs->scheduled_date)->format('H:i'),
                'original_type' => 'observation',
            ]);
        }

        $typeLabels = [
            'umum' => 'Assessment Umum',
            'fisio' => 'Assessment Fisio',
            'okupasi' => 'Assessment Okupasi',
            'wicara' => 'Assessment Wicara',
            'paedagog' => 'Assessment Paedagog',
        ];

        foreach ($assessments as $assessment) {
            $allSchedules->push([
                'id' => $assessment->id,
                'child_id' => $assessment->assessment?->child?->id ?? 'unknown',
                'child_name' => $assessment->assessment?->child?->child_name ?? 'No Child',
                'type_label' => $typeLabels[$assessment->type] ?? 'Assessment',
                'status' => ucfirst($assessment->status),
                'scheduled_date' => $assessment->scheduled_date,
                'date' => Carbon::parse($assessment->scheduled_date)->format('d/m/Y'),
                'time' => Carbon::parse($assessment->scheduled_date)->format('H:i'),
                'original_type' => 'assessment',
            ]);
        }

        $grouped = $allSchedules->groupBy(function ($item) {
            return $item['child_id'] . '|' . $item['date'] . '|' . $item['time'];
        });

        $result = $grouped->map(function ($group) {
            $first = $group->first();

            return [
                'id' => $group->pluck('id')->implode(','),
                'child_name' => $first['child_name'],
                'types' => $group->pluck('type_label')->unique()->sort()->values()->toArray(),
                'status' => $first['status'],
                'date' => $first['date'],
                'time' => $first['time'],
                'scheduled_date' => $first['scheduled_date'],
            ];
        })
            ->sortBy('scheduled_date')
            ->values()
            ->map(function ($item) {
                unset($item['scheduled_date']);
                return $item;
            });

        return $result;
    }
}
