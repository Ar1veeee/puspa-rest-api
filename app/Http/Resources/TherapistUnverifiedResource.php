<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistUnverifiedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'therapist_id' => $this->therapist->id,
            'email' => $this->email,
            'therapist_name' => $this->therapist->therapist_name,
            'therapist_phone' => $this->therapist->therapist_phone,
            'createdAt' => $this->created_at->format('d F Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d F Y H:i:s'),
        ];

        return $response;
    }
}
