<?php

namespace App\Listeners;

use App\Events\AssessmentUpdated;
use App\Traits\ClearsCaches;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ClearAssessmentCache
{
    use ClearsCaches;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AssessmentUpdated $event): void
    {
        $this->clearAssessmentCaches();
    }
}
