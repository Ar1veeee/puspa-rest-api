<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ClearsCaches
{
    /**
     * Clear observation list caches
     */
    protected function clearObservationCaches(): void
    {
        Cache::forget('observations_pending');

        Cache::forget("observations_scheduled");
    }

    /**
     * Clear question cache by age category
     */
    protected function clearQuestionCache(string $ageCategory): void
    {
        Cache::forget("observation_questions_{$ageCategory}");
    }

    /**
     * Clear all question caches
     */
    protected function clearAllQuestionCaches(): void
    {
        $ageCategories = ['balita', 'anak-anak', 'remaja', 'lainya'];

        foreach ($ageCategories as $category) {
            Cache::forget("observation_questions_{$category}");
        }
    }
}
