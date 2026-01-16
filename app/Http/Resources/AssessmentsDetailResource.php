<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentsDetailResource extends JsonResource
{
    public function toArray($request)
    {
        $scheduled = $this->scheduled_date
            ? Carbon::parse($this->scheduled_date)
            : null;

        $currentStatus = $this->status;
        $parentStatus  = $this->parent_status;

        return [
            'assessment_id' => $this->id,

            'details' => $this->assessmentDetails->map(function ($d) use ($scheduled, $currentStatus, $parentStatus) {

                $parentCompletedAt = $d->parent_completed_at
                    ? Carbon::parse($d->parent_completed_at)
                    : null;

                return [
                    'assessment_detail_id'    => $d->id,
                    'type'                    => $d->type,

                    'status'                  => $currentStatus,
                    'scheduled_date'          => $scheduled?->format('d/m/Y'),
                    'scheduled_time'          => $scheduled?->format('H.i'),
                    'parent_completed_status' => $parentStatus,

                    'completed_at'            => $d->completed_at,
                    'parent_completed_at'     => $parentCompletedAt?->format('H:i'),
                    'therapist_id'            => $d->therapist_id,
                    'admin_id'                => $d->admin_id,
                ];
            }),

            'report' => $this->when($this->report_file, function () {
                return [
                    'available'    => true,
                    'uploaded_at'  => $this->report_uploaded_at?->format('d/m/Y H:i'),
                    'download_url' => route('parent.assessment.report.download', $this->id)
                ];
            }, [
                'available'    => false,
                'uploaded_at'  => null,
                'download_url' => null
            ]),
        ];
    }
}
