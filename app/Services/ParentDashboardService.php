<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Observation;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use Carbon\Carbon;

class ParentDashboardService
{
    /**
     * Get dashboard statistics for parent
     */
    public function getStats(string $familyId): array
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();

        $childIds = Child::where('family_id', $familyId)->pluck('id');

        if ($childIds->isEmpty()) {
            return $this->getEmptyStats();
        }

        $totalChildren = $childIds->count();
        $totalChildrenLastMonth = Child::where('family_id', $familyId)
            ->where('created_at', '<=', $lastMonth)
            ->count();

        $totalObservations = Observation::whereIn('child_id', $childIds)->count();
        $totalObservationsLastMonth = Observation::whereIn('child_id', $childIds)
            ->where('created_at', '<=', $lastMonth)
            ->count();

        $assessmentIds = Assessment::whereIn('child_id', $childIds)->pluck('id');
        $totalAssessments = AssessmentDetail::whereIn('assessment_id', $assessmentIds)->count();
        $totalAssessmentsLastMonth = AssessmentDetail::whereIn('assessment_id', $assessmentIds)
            ->where('created_at', '<=', $lastMonth)
            ->count();

        return [
            'total_children' => $totalChildren,
            'total_children_percentage' => $this->calculatePercentage($totalChildren, $totalChildrenLastMonth),

            'total_observations' => $totalObservations,
            'total_observations_percentage' => $this->calculatePercentage($totalObservations, $totalObservationsLastMonth),

            'total_assessments' => $totalAssessments,
            'total_assessments_percentage' => $this->calculatePercentage($totalAssessments, $totalAssessmentsLastMonth),
        ];
    }

    /**
     * Get chart data for trend visualization (last 12 months)
     */
    public function getChartData(string $familyId): array
    {
        $childIds = Child::where('family_id', $familyId)->pluck('id');

        if ($childIds->isEmpty()) {
            return [];
        }

        $months = collect(range(11, 0))->map(function ($monthsAgo) {
            return Carbon::now()->subMonths($monthsAgo);
        });

        return $months->map(function ($month) use ($childIds, $familyId) {
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $totalChildren = Child::where('family_id', $familyId)
                ->where('created_at', '<=', $endOfMonth)
                ->count();

            $totalObservations = Observation::whereIn('child_id', $childIds)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            $assessmentIds = Assessment::whereIn('child_id', $childIds)->pluck('id');
            $totalAssessments = AssessmentDetail::whereIn('assessment_id', $assessmentIds)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();

            return [
                'month' => $month->format('M Y'),
                'total_children' => $totalChildren,
                'total_observations' => $totalObservations,
                'total_assessments' => $totalAssessments,
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
