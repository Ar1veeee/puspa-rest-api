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
        $children = $this->map(function ($child) {
            return [
                'assessment_id' => $child->assessment->id,
                'child_id' => $child->assessment->child_id,
                'family_id' => $child->family_id,
                'child_name' => $child->child_name,
                'child_birth_info' => $child->child_birth_place . ', ' . $child->child_birth_date->format('d F Y'),
                'child_age' => $child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
                'child_gender' => $child->child_gender,
                'child_school' => $child->child_school,
                'scheduled_date' => $child->assessment->scheduled_date->toDateString(),
                'status' => $child->assessment->status,
                'created_at' => $child->assessment->created_at->format('d F Y H:i:s'),
                'updated_at' => $child->assessment->updated_at->format('d F Y H:i:s'),
            ];
        });
        return [
            'children' => $children,
        ];
    }
}
