<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuardianProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = $this->user->role === 'user' ? 'Orangtua Pasien/Anak' : '';

        return [
            'guardian_id' => $this->id,
            'family_id' => $this->family_id,
            'user_id' => $this->user_id,
            'guardian_name' => $this->guardian_name,
            'guardian_type' => $this->guardian_type,
            'relationship_with_child' => $this->relationship_with_child,
            'guardian_birth_date' => $this->guardian_birth_date->format('d-m-Y'),
            'guardian_phone' => $this->guardian_phone,
            'email' => $this->user->email,
            'role' => $role,
            'guardian_occupation' => $this->guardian_occupation,
        ];
    }
}
