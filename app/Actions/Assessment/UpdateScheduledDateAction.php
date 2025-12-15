<?php

namespace App\Actions\Assessment;

use App\Events\AssessmentUpdated;
use App\Models\Assessment;
use Carbon\Carbon;

class UpdateScheduledDateAction
{
    public function execute(Assessment $assessment, array $data): void
    {
        if (empty($data['scheduled_date']) || empty($data['scheduled_time'])) {
            return;
        }

        $newDate = Carbon::createFromFormat('Y-m-d H:i', $data['scheduled_date'] . ' ' . $data['scheduled_time']);

        $assessment->assessmentDetails()->update([
            'scheduled_date' => $newDate,
            'status'         => 'scheduled',
            'admin_id'       => auth()->user()->admin->id,
        ]);

        event(new AssessmentUpdated());
    }
}
