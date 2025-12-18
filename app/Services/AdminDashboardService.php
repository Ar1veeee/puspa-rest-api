<?php

namespace App\Services;

use App\Http\Resources\TodayAssessmentScheduleResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    public function getDashboardData(string $date): array
    {
        $carbonDate = Carbon::parse($date);

        return [
            'date' => [
                'current' => $carbonDate->toDateString(),
                'formatted' => $carbonDate->translatedFormat('l, d F Y'),
            ],
            'metrics' => [
                'assessment_today' => $this->getAssessmentToday($carbonDate),
                'observation_today' => $this->getObservationToday($carbonDate),
                'active_patients' => $this->getActivePatients(),
            ],
            'patient_categories' => $this->getPatientCategories(),
        ];
    }

    private function getAssessmentToday(Carbon $date): int
    {
        return DB::table('assessment_details')
            ->join('assessments', 'assessment_details.assessment_id', '=', 'assessments.id')
            ->where('assessment_details.status', 'scheduled')
            ->whereDate('assessment_details.scheduled_date', $date)
            ->distinct()
            ->count('assessments.id');
    }

    private function getObservationToday(Carbon $date): int
    {
        return DB::table('observations')
            ->where('status', 'scheduled')
            ->whereDate('scheduled_date', $date)
            ->count();
    }

    private function getActivePatients(): int
    {
        $sixMonthsAgo = now()->subMonths(6);

        return DB::table('children as c')
            ->where(function ($query) use ($sixMonthsAgo) {
                $query->whereExists(function ($subQuery) use ($sixMonthsAgo) {
                    $subQuery->select(DB::raw(1))
                        ->from('observations as o')
                        ->whereColumn('o.child_id', 'c.id')
                        ->where('o.created_at', '>=', $sixMonthsAgo);
                })
                    ->orWhereExists(function ($subQuery) use ($sixMonthsAgo) {
                        $subQuery->select(DB::raw(1))
                            ->from('assessments as a')
                            ->whereColumn('a.child_id', 'c.id')
                            ->where('a.created_at', '>=', $sixMonthsAgo);
                    });
            })
            ->distinct()
            ->count('c.id');
    }

    private function getPatientCategories(): array
    {
        $categories = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->select(
                'ad.type',
                DB::raw('COUNT(DISTINCT a.child_id) as count')
            )
            ->whereIn('ad.status', ['scheduled', 'completed'])
            ->groupBy('ad.type')
            ->get();

        $total = $categories->sum('count');

        $typeMapping = [
            'fisio' => 'Fisio',
            'okupasi' => 'Okupasi',
            'wicara' => 'Wicara',
            'paedagog' => 'Paedagog'
        ];

        return $categories->map(function ($category) use ($total, $typeMapping) {
            return [
                'type' => $typeMapping[$category->type] ?? ucfirst($category->type),
                'type_key' => $category->type,
                'count' => $category->count,
                'percentage' => $total > 0 ? round(($category->count / $total) * 100, 1) : 0
            ];
        })->sortByDesc('percentage')->values()->toArray();
    }

    public function getTodayTherapySchedule(string $date): TodayAssessmentScheduleResource
    {
        $raw = DB::table('assessments as a')
            ->join('children as c', 'a.child_id', '=', 'c.id')
            ->join('assessment_details as ad', 'ad.assessment_id', '=', 'a.id')
            ->leftJoin('therapists as t', 'ad.therapist_id', '=', 't.id')
            ->select(
                'a.id as assessment_id',
                'c.child_name',
                'ad.type',
                'ad.scheduled_date',
                DB::raw("DATE(ad.scheduled_date) as schedule_date"),
                DB::raw("TIME_FORMAT(TIME(ad.scheduled_date), '%H:%i') as waktu")
            )
            ->where('ad.status', 'scheduled')
            ->whereDate('ad.scheduled_date', $date)
            ->orderBy('ad.scheduled_date')
            ->get();

        $grouped = $raw->groupBy('assessment_id');

        return new TodayAssessmentScheduleResource($grouped);
    }
}
