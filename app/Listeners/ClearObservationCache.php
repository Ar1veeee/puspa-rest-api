<?php

namespace App\Listeners;

use App\Events\ObservationUpdated;
use App\Traits\ClearsCaches;

class ClearObservationCache
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
    public function handle(ObservationUpdated $event): void
    {
        $this->clearObservationCaches();
    }
}
