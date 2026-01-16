<?php

namespace App\Actions\Assessment;

use App\Events\AssessmentUpdated;
use App\Models\Assessment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateScheduledDateAction
{
    public function execute(Assessment $assessment, array $data): void
    {
        if (empty($data['scheduled_date']) || empty($data['scheduled_time'])) {
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

        $this->validateScheduleGap($assessment, $date);

        $admin = auth()->user()->admin;

        DB::transaction(function () use ($assessment, $date, $admin) {
            $assessment->assessmentDetails()->update([
                'admin_id' => $admin->id,
            ]);

            $assessment->update([
                'scheduled_date' => $date,
                'status' => 'scheduled',
            ]);

            event(new AssessmentUpdated());
        });
    }

    private function validateScheduleGap(Assessment $assessment, Carbon $date): void
    {
        $twoHoursBefore = $date->copy()->subHours(2);
        $twoHoursAfter = $date->copy()->addHours(2);

        $conflictingAssessment = Assessment::query()
            ->where('id', '!=', $assessment->id)
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
