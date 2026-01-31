<?php

namespace App\Http\Resources;

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
        $formattedBirthDate = $this->child_birth_date ? $this->child_birth_date->translatedFormat('d F Y') : null;
        $age = $this->child_birth_date ? $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan') : null;

        $guardian = $this->family->guardians->first();

        $response = [
            "child_id" => $this->id,
            'child_name' => $this->child_name,
            'parent_name' => $guardian->guardian_name,
            'parent_phone' => $guardian->guardian_phone,
            'parent_email' => $guardian->user?->email ?? $guardian->temp_email,
            'child_birth_date' => $formattedBirthDate,
            'child_age' => $age,
            'child_gender' => $this->child_gender,
            'child_school' => $this->child_school,
        ];

        return $response;
    }
}
