<?php

namespace App\Actions\Observation;

use App\Events\ObservationUpdated;
use App\Models\Observation;
use Carbon\Carbon;

class RescheduleObservationAction
{
    public function execute(Observation $observation, array $data): void
    {
        if (! in_array($observation->status, ['pending', 'scheduled'])) {
            throw new \InvalidArgumentException(
                'Observation hanya dapat di-reschedule jika statusnya pending atau scheduled.'
            );
        }

        if (empty($data['scheduled_date']) || empty($data['scheduled_time'])) {
            return;
        }

        $newDateTime = $data['scheduled_date'] . ' ' . $data['scheduled_time'];
        $newDate = Carbon::createFromFormat('Y-m-d H:i', $newDateTime);

        if (! $newDate) {
            throw new \InvalidArgumentException('Format tanggal dan waktu tidak valid.');
        }

        if (! $newDate->equalTo($observation->scheduled_date)) {
            $observation->update([
                'scheduled_date' => $newDate,
                'status'         => 'scheduled',
                'admin_id'       => auth()->id() ? auth()->user()->admin->id : null,
            ]);

            event(new ObservationUpdated($observation));
        }
    }
}
