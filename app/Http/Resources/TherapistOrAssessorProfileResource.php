<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TherapistOrAssessorProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = $this->user->getRoleNames()->first() === 'terapis' ? 'Terapis' : 'Asesor';

        return [
            'user_id' => $this->user_id,
            'therapist_id' => $this->id,
            'therapist_name' => $this->therapist_name,
            'therapist_phone' => $this->therapist_phone,
            'therapist_birth_date' => $this->therapist_birth_date
                ? $this->therapist_birth_date->format('Y-m-d')
                : 'Tanggal Lahir Kosong',
            'therapist_section' => $this->therapist_section,
            'email' => $this->user->email,
            'role' => $role,
            'profile_picture' => $this->profile_picture
            ? Storage::url($this->profile_picture)
                : null,
        ];
    }
}
