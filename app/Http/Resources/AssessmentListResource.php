<?php

namespace App\Http\Resources;

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
        $guardian = $this->child?->family?->guardians?->first();

        return [
            'assessment_id' => $this->id,
            'child_name' => $this->child?->child_name,
            'child_age' => $this->child?->child_birth_date?->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child?->child_gender,
            'guardian_name' => $guardian?->guardian_name,
            'guardian_phone' => $guardian?->guardian_phone,
            'scheduled_date' => $this->scheduled_date?->toDateString(),
            'status' => $this->status,
        ];
    }
}
