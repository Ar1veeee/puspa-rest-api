<?php

namespace App\Actions\Observation;

use App\Events\ObservationUpdated;
use App\Models\Observation;
use Carbon\Carbon;

class RescheduleObservationAction
{
    public function execute(Observation $observation, array $data): void
    {
        if (empty($data['scheduled_date']) || empty($data['scheduled_time'])) {
            return;
        }

        $newDate = Carbon::createFromFormat('Y-m-d H:i', $data['scheduled_date'] . ' ' . $data['scheduled_time']);

        if ($newDate && !$newDate->equalTo($observation->scheduled_date)) {
            $observation->update([
                'scheduled_date' => $newDate,
                'status'         => 'scheduled',
                'admin_id'       => auth()->user()->admin->id,
            ]);
        }

        event(new ObservationUpdated());
    }
}
