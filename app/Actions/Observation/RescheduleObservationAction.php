<?php

namespace App\Actions\Observation;

use App\Events\ObservationUpdated;
use App\Models\Observation;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class RescheduleObservationAction
{
    public function execute(Observation $observation, array $data): void
    {
        if (!in_array($observation->status, ['pending', 'scheduled'])) {
            throw ValidationException::withMessages([
                'Observation hanya dapat di-reschedule jika statusnya pending atau scheduled.'
            ]);
        }

        if (empty($data['scheduled_date']) || empty($data['scheduled_time'])) {
            return;
        }

        $newDateTime = $data['scheduled_date'] . ' ' . $data['scheduled_time'];
        $newDate = Carbon::createFromFormat('Y-m-d H:i', $newDateTime);

        if (!$newDate) {
            throw ValidationException::withMessages([
                'Format tanggal dan waktu tidak valid.'
            ]);
        }

        if ($newDate->isPast()) {
            throw ValidationException::withMessages([
                'Jadwal observasi tidak bisa di bawah dari waktu sekarang.'
            ]);
        }

        $this->validateScheduleGap($observation, $newDate);

        if (!$newDate->equalTo($observation->scheduled_date)) {
            $observation->update([
                'scheduled_date' => $newDate,
                'status' => 'scheduled',
                'admin_id' => auth()->id() ? auth()->user()->admin->id : null,
            ]);

            event(new ObservationUpdated($observation));
        }
    }

    private function validateScheduleGap(Observation $observation, Carbon $newDate): void
    {
        $twoHoursBefore = $newDate->copy()->subHours(2);
        $twoHoursAfter = $newDate->copy()->addHours(2);

        $conflictingObservation = Observation::query()
            ->where('id', '!=', $observation->id)
            ->whereIn('status', ['scheduled', 'completed'])
            ->whereNotNull('scheduled_date')
            ->where(function ($query) use ($twoHoursBefore, $twoHoursAfter) {
                $query->whereBetween('scheduled_date', [$twoHoursBefore, $twoHoursAfter]);
            })
            ->first();

        if ($conflictingObservation) {
            $conflictTime = Carbon::parse($conflictingObservation->scheduled_date)
                ->timezone('Asia/Jakarta')
                ->format('d/m/Y H:i');

            throw ValidationException::withMessages([
                "Jadwal observasi bentrok, berikan jeda 2 jam dengan observasi lain. Terdapat observasi pada {$conflictTime}."
            ]);
        }
    }
}
