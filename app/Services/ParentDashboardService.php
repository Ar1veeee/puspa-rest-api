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

        $assStats = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->whereIn('a.child_id', $childIds)
            ->selectRaw('
            COUNT(*) as total,
            COUNT(CASE WHEN ad.created_at <= ? THEN 1 END) as last_month
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

        $assessments = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->whereIn('a.child_id', $childIds)
            ->whereBetween('ad.created_at', [$start, $end])
            ->selectRaw('DATE_FORMAT(ad.created_at, "%Y-%m") as month, COUNT(*) as count')
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

        $childIds = Child::where('family_id', $familyId)->pluck('id');

        if ($childIds->isEmpty()) {
            return collect();
        }

        $schedules = collect();

        if ($type === 'all' || $type === 'observation') {
            $observations = Observation::with([
                'child:id,child_name',
                'therapist:id,therapist_name'
            ])
                ->whereIn('child_id', $childIds)
                ->where('status', 'scheduled')
                ->where('scheduled_date', '>=', now())
                ->when($search, fn($q) => $q->whereHas(
                    'child',
                    fn($c) =>
                    $c->where('child_name', 'like', "%{$search}%")
                ))
                ->orderBy('scheduled_date', 'asc')
                ->get()
                ->map(function ($obs) {
                    return [
                        'id' => $obs->id,
                        'type' => 'observation',
                        'type_label' => 'Observasi',
                        'child_name' => $obs->child->child_name,
                        'service' => 'Observasi',
                        'status' => $obs->status,
                        'status_label' => 'Terjadwal',
                        'scheduled_date' => $obs->scheduled_date,
                        'date' => Carbon::parse($obs->scheduled_date)->format('d/m/Y'),
                        'time' => Carbon::parse($obs->scheduled_date)->format('H:i'),
                        'therapist' => $obs->therapist?->therapist_name ?? '-',
                    ];
                });

            $schedules = $schedules->merge($observations);
        }

        if ($type === 'all' || $type === 'assessment') {
            $assessmentIds = Assessment::whereIn('child_id', $childIds)->pluck('id');

            $assessments = AssessmentDetail::with([
                'assessment.child:id,child_name',
                'therapist:id,therapist_name'
            ])
                ->whereIn('assessment_id', $assessmentIds)
                ->where('status', 'scheduled')
                ->where('scheduled_date', '>=', now())
                ->when($search, fn($q) => $q->whereHas(
                    'assessment.child',
                    fn($c) =>
                    $c->where('child_name', 'like', "%{$search}%")
                ))
                ->orderBy('scheduled_date', 'asc')
                ->get()
                ->map(function ($detail) {
                    $typeLabels = [
                        'fisio' => 'Assessment Fisio',
                        'okupasi' => 'Assessment Okupasi',
                        'wicara' => 'Assessment Wicara',
                        'paedagog' => 'Assessment Paedagog',
                    ];

                    return [
                        'id' => $detail->id,
                        'type' => 'assessment',
                        'type_label' => $typeLabels[$detail->type] ?? 'Assessment',
                        'child_name' => $detail->assessment->child->child_name,
                        'service' => $typeLabels[$detail->type] ?? 'Assessment',
                        'status' => $detail->status,
                        'status_label' => 'Terjadwal',
                        'scheduled_date' => $detail->scheduled_date,
                        'date' => Carbon::parse($detail->scheduled_date)->format('d/m/Y'),
                        'time' => Carbon::parse($detail->scheduled_date)->format('H:i'),
                        'therapist' => $detail->therapist?->therapist_name ?? '-',
                    ];
                });

            $schedules = $schedules->merge($assessments);
        }

        return $schedules->sortBy('scheduled_date')->values();
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
