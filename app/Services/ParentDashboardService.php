<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Observation;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ParentDashboardService
{
    /**
     * Get dashboard statistics for parent
     */
    public function getStats(string $familyId): array
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();

        $children = Child::where('family_id', $familyId)->get();

        if ($children->isEmpty()) {
            return $this->getEmptyStats();
        }

        $childIds = $children->pluck('id');

        $totalChildren = $children->count();
        $totalChildrenLastMonth = $children->filter(fn($c) => $c->created_at <= $lastMonth)->count();

        $obsStats = Observation::whereIn('child_id', $childIds)
            ->selectRaw('
            COUNT(*) as total,
            COUNT(CASE WHEN created_at <= ? THEN 1 END) as last_month
        ', [$lastMonth])
            ->first();

        $assStats = Assessment::whereIn('child_id', $childIds)
            ->selectRaw('
                COUNT(*) as total,
                COUNT(CASE WHEN created_at <= ? THEN 1 END) as last_month
            ', [$lastMonth])
            ->first();

        return [
            'total_children' => $totalChildren,
            'total_children_percentage' => $this->calculatePercentage($totalChildren, $totalChildrenLastMonth),

            'total_observations' => $obsStats->total,
            'total_observations_percentage' => $this->calculatePercentage($obsStats->total, $obsStats->last_month),

            'total_assessments' => $assStats->total,
            'total_assessments_percentage' => $this->calculatePercentage($assStats->total, $assStats->last_month),
        ];
    }

    /**
     * Get chart data for trend visualization (last 12 months)
     */
    public function getChartData(string $familyId): array
    {
        $children = Child::where('family_id', $familyId)->select('id', 'created_at')->get();

        if ($children->isEmpty()) {
            return [];
        }

        $childIds = $children->pluck('id');

        $start = Carbon::now()->subMonths(11)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $observations = Observation::whereIn('child_id', $childIds)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        $assessments = Assessment::whereIn('child_id', $childIds)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        return collect(range(11, 0))->map(function ($i) use ($children, $observations, $assessments) {
            $month = Carbon::now()->subMonths($i);
            $endOfMonth = $month->copy()->endOfMonth();

            $cumulativeChildren = $children->filter(fn($c) => $c->created_at <= $endOfMonth)->count();
            $monthKey = $month->format('Y-m');

            return [
                'month' => $month->translatedFormat('M Y'),
                'total_children' => $cumulativeChildren,
                'total_observations' => $observations[$monthKey] ?? 0,
                'total_assessments' => $assessments[$monthKey] ?? 0,
            ];
        })->toArray();
    }

    /**
     * Get upcoming schedules (observations + assessments)
     */
    public function getUpcomingSchedules(string $familyId, array $filters = [])
    {
        $search = $filters['search'] ?? null;
        $type = $filters['type'] ?? 'all';

        $obsQuery = DB::table('observations as o')
            ->join('children as c', 'o.child_id', '=', 'c.id')
            ->leftJoin('therapists as t', 'o.therapist_id', '=', 't.id')
            ->select([
                'o.id as id',
                DB::raw("'observation' as source_type"),
                DB::raw("'observation' as sub_type"),
                'o.scheduled_date',
                'o.status',
                'c.child_name',
                't.therapist_name',
            ])
            ->where('c.family_id', $familyId)
            ->where('o.status', 'scheduled')
            ->where('o.scheduled_date', '>=', now());

        if ($search) {
            $obsQuery->where('c.child_name', 'like', "%{$search}%");
        }

        $assQuery = DB::table('assessments as a')
            ->join('assessment_details as ad', 'a.id', '=', 'ad.assessment_id')
            ->join('children as c', 'a.child_id', '=', 'c.id')
            ->leftJoin('therapists as t', 'ad.therapist_id', '=', 't.id')
            ->select([
                'a.id as id',
                DB::raw("'assessment' as source_type"),
                'ad.type as sub_type',
                'a.scheduled_date',
                'a.status',
                'c.child_name',
                't.therapist_name',
            ])
            ->where('c.family_id', $familyId)
            ->where('a.status', 'scheduled')
            ->where('a.scheduled_date', '>=', now());

        if ($search) {
            $assQuery->where('c.child_name', 'like', "%{$search}%");
        }

        $finalQuery = null;

        if ($type === 'observation') {
            $finalQuery = $obsQuery;
        } elseif ($type === 'assessment') {
            $finalQuery = $assQuery;
        } else {
            $finalQuery = $obsQuery->union($assQuery);
        }

        $schedules = $finalQuery
            ->orderBy('scheduled_date', 'asc')
            ->get();

        return $schedules->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => $item->source_type,
                'type_label' => $this->getLabel($item->source_type, $item->sub_type),
                'child_name' => $item->child_name,
                'service' => $this->getLabel($item->source_type, $item->sub_type),
                'status' => $item->status,
                'status_label' => 'Terjadwal',
                'scheduled_date' => $item->scheduled_date,
                'date' => Carbon::parse($item->scheduled_date)->format('d/m/Y'),
                'time' => Carbon::parse($item->scheduled_date)->format('H:i'),
                'therapist' => $item->therapist_name ?? '-',
            ];
        });
    }

    private function getLabel(string $sourceType, string $subType): string
    {
        if ($sourceType === 'observation') {
            return 'Observasi';
        }

        $labels = [
            'umum' => 'Assessment Umum',
            'fisio' => 'Assessment Fisio',
            'okupasi' => 'Assessment Okupasi',
            'wicara' => 'Assessment Wicara',
            'paedagog' => 'Assessment Paedagog',
        ];

        return $labels[$subType] ?? 'Assessment';
    }

    /**
     * Calculate percentage change
     */
    private function calculatePercentage(int $current, int $previous): array
    {
        if ($previous == 0) {
            return [
                'value' => $current > 0 ? 100 : 0,
                'direction' => $current > 0 ? 'up' : 'neutral',
            ];
        }

        $change = (($current - $previous) / $previous) * 100;

        return [
            'value' => abs(round($change, 1)),
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'neutral'),
        ];
    }

    /**
     * Get empty stats structure
     */
    private function getEmptyStats(): array
    {
        return [
            'total_children' => 0,
            'total_children_percentage' => ['value' => 0, 'direction' => 'neutral'],
            'total_observations' => 0,
            'total_observations_percentage' => ['value' => 0, 'direction' => 'neutral'],
            'total_assessments' => 0,
            'total_assessments_percentage' => ['value' => 0, 'direction' => 'neutral'],
        ];
    }
}
