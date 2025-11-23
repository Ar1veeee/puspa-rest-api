<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentDetail;
use App\Models\Child;
use App\Models\Observation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getDashboardStats()
    {
        $today = Carbon::now();

        $assessmentTodayCount = AssessmentDetail::where('status', 'scheduled')
            ->whereDate('scheduled_date', $today)
            ->count();

        $observationTodayCount = Observation::where('status', 'scheduled')
            ->whereDate('scheduled_date', $today)
            ->count();

        $activePatientCount = Child::count();

        $patientCategoryDistribution = AssessmentDetail::select(
            'type',
            DB::raw('count(*) as count')
        )
            ->whereIn('status', ['scheduled', 'completed'])
            ->groupBy('type')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'assessment_today_count' => $assessmentTodayCount,
                'observation_today_count' => $observationTodayCount,
                'active_patient_count' => $activePatientCount,
                'category_distribution' => $patientCategoryDistribution,
            ]
        ]);
    }
}
