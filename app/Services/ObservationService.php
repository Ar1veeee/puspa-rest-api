<?php

namespace App\Services;

use App\Actions\Observation\AgreeToAssessmentAction;
use App\Actions\Observation\RescheduleObservationAction;
use App\Actions\Observation\SubmitObservationAction;
use App\Models\Observation;
use App\Models\ObservationQuestion;
use Illuminate\Support\Facades\Cache;

class ObservationService
{
    public const CACHE_TTL = 600;

    public function getObservations(array $filters = [])
    {
        $status = $filters['status'] ?? 'pending';
        $search = $filters['search'] ?? '';
        $date = $filters['date'] ?? '';

        if (!empty($search) || !empty($date)) {
            return $this->queryObservations($status, $search, $date);
        }

        $key = "observations_{$status}";
        return Cache::remember($key, self::CACHE_TTL, function () use ($status) {
            return $this->queryObservations($status, '', '');
        });
    }

    public function getQuestions(Observation $observation)
    {
        $key = "questions_{$observation->age_category}";

        return Cache::rememberForever($key, function () use ($observation) {
            return ObservationQuestion::where('age_category', $observation->age_category)->get();
        });
    }

    public function submit(Observation $observation, array $data): Observation
    {
        return (new SubmitObservationAction)->execute($observation, $data);
    }

    public function reschedule(Observation $observation, array $data): void
    {
        (new RescheduleObservationAction)->execute($observation, $data);
    }

    public function agreeToAssessment(Observation $observation, array $data): void
    {
        (new AgreeToAssessmentAction)->execute($observation, $data);
    }

    private function queryObservations(string $status, $search, $date)
    {
        return Observation::with([
            'child:id,family_id,child_name,child_school,child_gender,child_birth_date',
            'child.family:id',
            'child.family.guardians:id,family_id,guardian_name,guardian_phone,guardian_type',
            'therapist:id,therapist_name'
        ])
            ->where('status', $status)
            ->when(!empty($search), fn($q) => $q->whereHas(
                'child',
                fn($c) => $c->where('child_name', 'like', "%{$search}%")
            ))
            ->when(!empty($date), fn($q) => $q->whereDate('scheduled_date', $date))
            ->orderBy('scheduled_date', 'asc')
            ->get();
    }
}
