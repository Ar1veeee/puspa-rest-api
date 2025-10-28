<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationCompletedDetailResource extends JsonResource
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
            "observation_id" => $this->id,
            'child_name' => $this->child->child_name,
            'child_birth_place_date' => $this->child->child_birth_place . ', ' . $this->child->child_birth_date->translatedFormat('d F Y'),
            'child_age' => $this->child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child->child_gender,
            'child_school' => $this->child->child_school,
            'child_address' => $this->child->child_address,
            'parent_name' => $guardian->guardian_name,
            'parent_type' => $guardian->guardian_type,
            'total_score' => $this->total_score,
            'recommendation' => $this->recommendation,
            'conclusion' => $this->conclusion,
        ];
    }
}
