<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $scheduled_date_formatted = $this->scheduled_date instanceof Carbon
            ? $this->scheduled_date
            : Carbon::parse($this->scheduled_date);

        $completed_at_formatted = null;
        if ($this->completed_at) {
            $completed_at_formatted = $this->completed_at instanceof Carbon
                ? $this->completed_at
                : Carbon::parse($this->completed_at);
        }

        $child    = $this->assessment?->child;
        $guardian = $this->assessment?->child?->family?->guardians?->first();

        $typeLabel = match ($this->type) {
            'fisio'     => 'Assessment Fisio',
            'okupasi'   => 'Assessment Okupasi',
            'wicara'    => 'Assessment Wicara',
            'paedagog'  => 'Assessment Paedagog',
            'umum'      => 'Assessment Umum',
            default     => 'Assessment Umum',
        };

        return [
            'assessment_detail_id' => $this->id,
            'assessment_id'   => $this->assessment->id,
            'child_id'        => $child?->id,
            'child_name'      => $child?->child_name,
            'guardian_name'   => $guardian?->guardian_name,
            'guardian_phone'  => $guardian?->guardian_phone,
            'type'            => $typeLabel,
            'administrator'   => $this->admin?->admin_name,
            'assessor'        => $this->therapist?->therapist_name,
            'scheduled_date'  => $scheduled_date_formatted->format('d/m/Y'),
            'scheduled_time'  => $scheduled_date_formatted->format('H.i'),
            'completed_at'    => $completed_at_formatted
                ? $completed_at_formatted->format('H.i')
                : 'Belum Selesai',
            'status'          => $this->status,
        ];
    }
}
