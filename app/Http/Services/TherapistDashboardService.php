<?php

namespace App\Http\Services;

use App\Models\AssessmentDetail;
use App\Models\Observation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
                'total_assessments'  => $this->getTotalAssessments($therapistId, $month, $year), // ← BARU
                'total_therapists'   => $this->getTotalTherapists($month, $year),
                'completion_rate'    => $this->getCompletionRate($therapistId, $month, $year),
                'total_assessors'    => $this->getTotalAssessors($month, $year),
            ],
            'patient_categories' => $this->getPatientCategories($therapistId, $month, $year),
            'trend_chart'        => $this->getTrendChart($therapistId, $month, $year),
        ];
    }

    public function getUpcomingSchedulesCollection(string $therapistId, int $limit = 50)
    {
        $observations = Observation::with('child:id,child_name')
            ->where('therapist_id', $therapistId)
            ->where('status', 'scheduled')
            ->where('scheduled_date', '>=', now())
            ->orderBy('scheduled_date', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($obs) {
                return [
                    'id' => $obs->id,
                    'nama_pasien' => $obs->child->child_name,
                    'jenis_layanan' => 'Observasi',
                    'status' => ucfirst($obs->status),
                    'tanggal' => Carbon::parse($obs->scheduled_date)->format('d/m/Y'),
                    'waktu' => Carbon::parse($obs->scheduled_date)->format('H:i'),
                    'type' => 'observation',
                ];
            });

        $assessments = AssessmentDetail::with('assessment.child:id,child_name')
            ->where('therapist_id', $therapistId)
            ->where('status', 'scheduled')
            ->where('scheduled_date', '>=', now())
            ->orderBy('scheduled_date', 'asc')
            ->limit($limit)
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
                    'nama_pasien' => $detail->assessment->child->child_name,
                    'jenis_layanan' => $typeLabels[$detail->type] ?? 'Assessment',
                    'status' => ucfirst($detail->status),
                    'tanggal' => Carbon::parse($detail->scheduled_date)->format('d/m/Y'),
                    'waktu' => Carbon::parse($detail->scheduled_date)->format('H:i'),
                    'type' => 'assessment',
                ];
            });

        return $observations->concat($assessments)
            ->sortBy('tanggal')
            ->values();
    }

    private function getTotalAssessments(string $therapistId, int $month, int $year): array
    {
        $current = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $previousMonth = $month === 1 ? 12 : $month - 1;
        $previousYear = $month === 1 ? $year - 1 : $year;

        $previous = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $previousYear)
            ->whereMonth('created_at', $previousMonth)
            ->count();

        return $this->calculateChange($current, $previous);
    }

    private function getTotalObservations(string $therapistId, int $month, int $year): array
    {
        $current = DB::table('observations')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $previousMonth = $month === 1 ? 12 : $month - 1;
        $previousYear = $month === 1 ? $year - 1 : $year;

        $previous = DB::table('observations')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $previousYear)
            ->whereMonth('created_at', $previousMonth)
            ->count();

        return $this->calculateChange($current, $previous);
    }

    private function getTotalTherapists(int $month, int $year): array
    {
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

    private function getTotalAssessors(int $month, int $year): array
    {
        $current = DB::table('assessment_details')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('therapist_id')
            ->distinct('therapist_id')
            ->count();
        $previous = DB::table('assessment_details')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month - 1 ?: 12)
            ->whereNotNull('therapist_id')
            ->distinct('therapist_id')
            ->count();
        return $this->calculateChange($current, $previous);
    }

    private function getCompletionRate(string $therapistId, int $month, int $year): array
    {
        $assessments = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        $total = $assessments->count();
        $completed = (clone $assessments)->where('status', 'completed')->count();
        $currentRate = $total > 0 ? round(($completed / $total) * 100) : 0;

        $prevMonth = $month === 1 ? 12 : $month - 1;
        $prevYear = $month === 1 ? $year - 1 : $year;

        $prevAssessments = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $prevYear)
            ->whereMonth('created_at', $prevMonth);

        $prevTotal = $prevAssessments->count();
        $prevCompleted = (clone $prevAssessments)->where('status', 'completed')->count();
        $previousRate = $prevTotal > 0 ? round(($prevCompleted / $prevTotal) * 100) : 0;

        return $this->calculateChange($currentRate, $previousRate, true);
    }

    private function getPatientCategories(string $therapistId, int $month, int $year): array
    {
        $categories = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->select('ad.type', DB::raw('COUNT(DISTINCT a.child_id) as count'))
            ->where('ad.therapist_id', $therapistId)
            ->whereYear('ad.created_at', $year)
            ->whereMonth('ad.created_at', $month)
            ->groupBy('ad.type')
            ->get();

        $total = $categories->sum('count');

        $mapping = [
            'fisio'     => 'Fisioterapi',
            'okupasi'   => 'Terapi Okupasi',
            'wicara'    => 'Terapi Wicara',
            'paedagog'  => 'Paedagogik',
        ];

        if ($categories->isEmpty()) {
            return [];
        }

        return $categories->map(function ($cat) use ($total, $mapping) {
            return [
                'type'       => $mapping[$cat->type] ?? ucfirst($cat->type),
                'count'       => $cat->count,
                'percentage'  => $total > 0 ? round(($cat->count / $total) * 100, 1) : 0
            ];
        })->sortByDesc('percentage')->values()->toArray();
    }

    private function getTrendChart(string $therapistId, int $month, int $year): array
    {
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $totalAnak = DB::table('observations')
            ->where('therapist_id', $therapistId)
            ->where('created_at', '<=', $endDate)
            ->distinct('child_id')
            ->count('child_id');

        $totalAssessment = DB::table('assessment_details')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $totalObservasi = DB::table('observations')
            ->where('therapist_id', $therapistId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $kategoriAnak = DB::table('assessment_details as ad')
            ->join('assessments as a', 'ad.assessment_id', '=', 'a.id')
            ->where('ad.therapist_id', $therapistId)
            ->whereYear('ad.created_at', $year)
            ->whereMonth('ad.created_at', $month)
            ->distinct('a.child_id')
            ->count('a.child_id');

        return [
            ['label' => 'Total Anak', 'value' => $totalAnak],
            ['label' => 'Kategori Anak', 'value' => $kategoriAnak],
            ['label' => 'Total Observasi', 'value' => $totalObservasi],
            ['label' => 'Total Assessment', 'value' => $totalAssessment],
        ];
    }

    private function calculateChange(int $current, int $previous, bool $isPercentage = false): array
    {
        if ($previous == 0) {
            $change = $current > 0 ? 100 : 0;
        } else {
            $change = round((($current - $previous) / $previous) * 100);
        }

        return [
            'current' => $isPercentage ? $current . '%' : $current,
            'previous' => $isPercentage ? $previous . '%' : $previous,
            'change_percent' => abs($change),
            'change_direction' => $change >= 0 ? 'increase' : 'decrease',
            'trend' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable'),
        ];
    }
}
