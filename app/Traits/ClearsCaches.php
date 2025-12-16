<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait ClearsCaches
{
    public function clearObservationCaches(): void
    {
        $statuses = ['pending', 'scheduled', 'completed'];

        foreach ($statuses as $status) {
            $key = "observations_{$status}";
            Cache::forget($key);
        }
    }

    public function clearAssessmentCaches(): void
    {
        $statuses = ['scheduled', 'completed', 'all'];
        $types = ['fisio', 'okupasi', 'paedagog', 'wicara', 'all'];

        foreach ($statuses as $status) {
            foreach ($types as $type) {
                $key = "assessments_{$status}_{$type}";
                Cache::forget($key);
            }
        }
    }
}
