<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildrenAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $assessment = $this->whenLoaded('assessment');

        return [
            'assessment_id' => $assessment->id,
            'child_id' => $this->id,
            'family_id' => $this->family_id,
            'child_name' => $this->child_name,
            'child_birth_info' => $this->child_birth_place . ', ' . $this->child_birth_date->format('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child_gender,
            'child_school' => $this->child_school,
            'scheduled_date' => $assessment->scheduled_date->toDateString(),
            'status' => $assessment->status,
            'created_at' => $assessment->created_at->format('d F Y H:i:s'),
            'updated_at' => $assessment->updated_at->format('d F Y H:i:s'),
        ];
    }
}
