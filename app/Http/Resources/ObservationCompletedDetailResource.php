<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="ObservationCompletedDetailResource",
 * type="object",
 * @OA\Property(property="id", type="integer", description="Observation ID"),
 * @OA\Property(property="child_name", type="string", description="Child's full name"),
 * @OA\Property(property="child_birth_place", type="string", description="Child's birth place and date"),
 * @OA\Property(property="child_age", type="integer", description="Child's current age in years"),
 * @OA\Property(property="child_gender", type="string", description="Child's gender"),
 * @OA\Property(property="child_school", type="string", nullable=true, description="Child's school"),
 * @OA\Property(property="child_address", type="string", description="Child's home address"),
 * @OA\Property(property="total_score", type="integer", description="Total score accumulated from the answers"),
 * @OA\Property(property="recommendation", type="string", description="Therapist's recommendation after the observation"),
 * @OA\Property(property="conclusion", type="string", description="Therapist's conclusion after the observation")
 * )
 */
class ObservationCompletedDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'child_name' => $this->child->child_name,
            'child_birth_place_date' => $this->child->child_birth_place . ', ' . $this->child->child_birth_date->format('d F Y'),
            'child_age' => $this->child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child->child_gender,
            'child_school' => $this->child->child_school,
            'child_address' => $this->child->child_address,
            'total_score' => $this->total_score,
            'recommendation' => $this->recommendation,
            'conclusion' => $this->conclusion,
        ];
    }
}
