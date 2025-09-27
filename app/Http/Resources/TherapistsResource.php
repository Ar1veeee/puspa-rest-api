<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'] ?? null,
            'user_id' => $this['user_id'] ?? null,
            'email' => $this['email'] ?? null,
            'username' => $this['username'] ?? null,
            'therapist_name' => $this['therapist_name'] ?? null,
            'therapist_section' => $this['therapist_section'] ?? null,
            'therapist_phone' => $this['therapist_phone'] ?? null,
            'createdAt' => $this['created_at'] ?? null,
            'updatedAt' => $this['updated_at'] ?? null,
        ];
    }
}
