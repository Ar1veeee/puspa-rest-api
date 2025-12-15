<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait ClearsCaches
{
    public function clearObservationCaches(): void
    {
        $statuses = ['pending', 'scheduled', 'completed'];
        $directions = ['asc', 'desc'];

        foreach ($statuses as $status) {
            foreach ($directions as $direction) {
                $key = "observations_{$status}_{$direction}";
                Cache::forget($key);
            }
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
