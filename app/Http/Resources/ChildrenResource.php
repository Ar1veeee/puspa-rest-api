<?php

namespace App\Http\Resources;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildrenResource extends JsonResource
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
            'child_name' => $this->child_name,
            'child_birth_date' => $this->child_birth_date->format('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            // 'child_age' => $age,
            'child_gender' => $this->child_gender,
            'child_school' => $this->child_school,
        ];
    }
}
