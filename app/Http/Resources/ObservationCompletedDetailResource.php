<?php

namespace App\Http\Resources;

use App\Models\Child;
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
        $age = null;
        if ($this->child && $this->child->child_birth_date) {
            $ageInfo = Child::calculateAgeAndCategory($this->child->child_birth_date);
            $age = $ageInfo['age'];
        }

        return [
            "id" => $this->id,
            'child_name' => $this->child->child_name,
            'child_birth_date' => $this->child->child_birth_date->toDateString(),
            'child_age' => $age,
            'child_gender' => $this->child->child_gender,
            'child_school' => $this->child->child_school,
            'child_address' => $this->child->child_address,
            'total_score' => $this->total_score,
            'recommendation' => $this->recommendation,
            'conclusion' => $this->conclusion,
        ];
    }
}
