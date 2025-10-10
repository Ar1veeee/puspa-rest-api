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
        $response = [
            "id" => $this->id,
            'child_name' => $this->child_name,
            'child_birth_date' => $this->child_birth_date->format('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child_gender,
            'child_school' => $this->child_school,
        ];

        return $response;
    }
}
