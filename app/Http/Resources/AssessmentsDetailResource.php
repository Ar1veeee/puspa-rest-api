<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentsDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'assessment_id' => $this->id,
            'child' => new ChildrenAssessmentResource($this->child),

            'details' => $this->assessmentDetails->map(function ($d) {
                return [
                    'assessment_detail_id' => $d->id,
                    'type' => $d->type,
                    'status' => $d->status,
                    'scheduled_date' => $d->scheduled_date,
                    'completed_at' => $d->completed_at,
                    'parent_completed_status' => $d->parent_completed_status,
                    'parent_completed_at' => $d->parent_completed_at,
                    'therapist_id' => $d->therapist_id,
                    'admin_id' => $d->admin_id,
                ];
            }),
        ];
    }
}
