<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            ->where('status', 'scheduled')
            ->whereDate('scheduled_date', $date)
            ->count();
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
            'fisio' => 'Fisioterapi',
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

    public function getTodayTherapySchedule(string $date, int $perPage, ?string $search, ?string $type)
    {
        $query = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->join('children as c', 'a.child_id', '=', 'c.id')
            ->leftJoin('therapists as t', 'ad.therapist_id', '=', 't.id')
            ->select(
                'ad.id',
                'c.child_name as nama_pasien',
                DB::raw("CASE
                    WHEN ad.type = 'fisio' THEN 'Fisioterapi'
                    WHEN ad.type = 'okupasi' THEN 'Okupasi'
                    WHEN ad.type = 'wicara' THEN 'Terapi Wicara'
                    WHEN ad.type = 'paedagog' THEN 'Paedagog'
                    ELSE UPPER(ad.type)
                END as jenis_terapi"),
                'ad.type as jenis_terapi_key',
                't.therapist_name as nama_terapis',
                'ad.status',
                'ad.scheduled_date as tanggal',
                DB::raw("TIME_FORMAT(TIME(ad.scheduled_date), '%H:%i') as waktu")
            )
            ->where('ad.status', 'scheduled')
            ->whereDate('ad.scheduled_date', $date);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('c.child_name', 'like', "%{$search}%")
                    ->orWhere('t.therapist_name', 'like', "%{$search}%");
            });
        }

        if ($type) {
            $query->where('ad.type', $type);
        }

        $query->orderBy('ad.scheduled_date', 'asc');

        return $query->paginate($perPage);
    }
}
