<?php

namespace App\Http\Resources;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationsScheduledResource extends JsonResource
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
            'age_category' => $this->age_category,
            'child_name' => $this->child->child_name,
            'child_gender' => $this->child->child_gender,
            'child_age' => $age,
            'child_school' => $this->child->child_school,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'status' => $this->status,
        ];
    }
}
