<?php

namespace App\Http\Resources;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationScheduledDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $guardian = $this->child?->family?->guardians?->first();
        $age = null;
        if ($this->child && $this->child->child_birth_date) {
            $ageInfo = Child::calculateAgeAndCategory($this->child->child_birth_date);
            $age = $ageInfo['age'];
        }

        return [
            "id" => $this->id,
            'child_name' => $this->child->child_name,
            'child_birth_date' => $this->child->child_birth_date,
            'child_age' => $age,
            'child_gender' => $this->child->child_gender,
            'child_school' => $this->child->child_school,
            'child_address' => $this->child->child_address,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'parent_name' => $guardian->guardian_name,
            'parent_type' => $guardian->guardian_type,
            'parent_phone' => $guardian->guardian_phone,
            'child_complaint' => $this->child->child_complaint,
            'child_service_choice' => $this->child->child_service_choice,
        ];
    }
}
