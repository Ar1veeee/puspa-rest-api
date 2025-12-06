<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentsDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'assessment_id' => $this->id,

            'details' => $this->assessmentDetails->map(function ($d) {
                $scheduledDate = $d->scheduled_date
                    ? Carbon::parse($d->scheduled_date)
                    : null;

                $parentCompletedAt = $d->parent_completed_at
                    ? Carbon::parse($d->parent_completed_at)
                    : null;

                return [
                    'assessment_detail_id'    => $d->id,
                    'type'                    => $d->type,
                    'status'                  => $d->status,
                    'scheduled_date'          => $scheduledDate?->format('d/m/Y'),
                    'scheduled_time'          => $scheduledDate?->format('H.i'),
                    'completed_at'            => $d->completed_at,
                    'parent_completed_status' => $d->parent_completed_status,
                    'parent_completed_at'     => $parentCompletedAt?->format('H:i'),
                    'therapist_id'            => $d->therapist_id,
                    'admin_id'                => $d->admin_id,
                ];
            }),
        ];
    }
}
