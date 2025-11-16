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

        $child = $this->assessment?->child;
        $guardian = $this->assessment?->child?->family?->guardians?->first();

        $type = $this->type;

        $types = [];

        if ($type === 'fisio')
        {
            $types = 'Assessment Fisio';
        }
        if ($type === 'wicara')
        {
            $types = 'Assessment Wicara';
        }
        if ($type === 'okupasi')
        {
            $types = 'Assessment Okupasi';
        }
        if ($type === 'paedagog')
        {
            $types = 'Assessment Paedagog';
        }

            return [
                'id' => $this->id,
                'assessment_id' => $this->assessment->id,
                'child_id' => $child?->id,
                'child_name' => $child?->child_name,
                'guardian_name' => $guardian?->guardian_name,
                'guardian_phone' => $guardian?->guardian_phone,
                'type' => $types,
                'administrator' => $this->admin?->admin_name,
                'assessor' => $this->therapist?->therapist_name,
                'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'), // Hanya tanggal
                'scheduled_time' => $scheduled_date_formatted->format('H.i'), // Hanya jam:menit
                'status' => $this->status,
            ];
    }
}
