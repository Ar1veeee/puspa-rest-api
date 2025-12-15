<?php

namespace App\Actions\Observation;

use App\Events\AssessmentUpdated;
use App\Events\ObservationUpdated;
use App\Models\Observation;
use App\Models\AssessmentDetail;
use Carbon\Carbon;

class AgreeToAssessmentAction
{
    public function execute(Observation $observation, array $data): void
    {
        if (empty($data['scheduled_date']) || empty($data['scheduled_time'])) {
            $observation->update(['is_continued_to_assessment' => true]);
            return;
        }

        $date = Carbon::createFromFormat('Y-m-d H:i', $data['scheduled_date'] . ' ' . $data['scheduled_time']);
        $admin = auth()->user()->admin;

        AssessmentDetail::whereHas('assessment', fn($q) => $q->where('observation_id', $observation->id))
            ->update([
                'scheduled_date' => $date,
                'status'         => 'scheduled',
                'admin_id'       => $admin->id,
            ]);

        $observation->update(['is_continued_to_assessment' => true]);

        event(new ObservationUpdated());
        event(new AssessmentUpdated());
    }
}
