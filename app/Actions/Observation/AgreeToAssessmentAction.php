<?php

namespace App\Actions\Observation;

use App\Events\AssessmentUpdated;
use App\Events\ObservationUpdated;
use App\Models\Assessment;
use App\Models\Observation;
use App\Models\AssessmentDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AgreeToAssessmentAction
{
    public function execute(Observation $observation, array $data): void
    {
        if (empty($data['scheduled_date']) || empty($data['scheduled_time'])) {
            $observation->update(['is_continued_to_assessment' => true]);
            return;
        }

        $date = Carbon::createFromFormat('Y-m-d H:i', $data['scheduled_date'] . ' ' . $data['scheduled_time']);

        if (!$date) {
            throw ValidationException::withMessages([
                'Format tanggal dan waktu tidak valid.'
            ]);
        }

        if ($date->isPast()) {
            throw ValidationException::withMessages([
                'Jadwal assessment tidak bisa di bawah dari waktu sekarang.'
            ]);
        }

        $this->validateScheduleGap($observation, $date);

        $admin = auth()->user()->admin;

        DB::transaction(function () use ($observation, $date, $admin) {
            AssessmentDetail::whereHas('assessment', fn($q) => $q->where('observation_id', $observation->id))
                ->update([
                    'admin_id' => $admin->id,
                ]);

            Assessment::where('observation_id', $observation->id)
                ->update([
                    'scheduled_date' => $date,
                    'status' => 'scheduled',
                ]);

            $observation->update(['is_continued_to_assessment' => true]);

            event(new ObservationUpdated($observation));
            event(new AssessmentUpdated());
        });
    }

    private function validateScheduleGap(Observation $observation, Carbon $date): void
    {
        $twoHoursBefore = $date->copy()->subHours(2);
        $twoHoursAfter = $date->copy()->addHours(2);

        $conflictingAssessment = Assessment::query()
            ->where('observation_id', '!=', $observation->id)
            ->where('status', 'scheduled')
            ->whereNotNull('scheduled_date')
            ->whereBetween('scheduled_date', [$twoHoursBefore, $twoHoursAfter])
            ->first();

        if ($conflictingAssessment) {
            $conflictTime = Carbon::parse($conflictingAssessment->scheduled_date)
                ->timezone('Asia/Jakarta')
                ->format('d/m/Y H:i');

            throw ValidationException::withMessages([
                "Jadwal assessment harus memiliki jeda minimal 2 jam dengan assessment lain. " .
                "Terdapat assessment pada {$conflictTime}."
            ]);
        }
    }
}
