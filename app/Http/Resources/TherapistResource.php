<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = $this->user->is_active ? 'Terverifikasi' : 'Tidak Terverifikasi';

        $response = [
            'user_id' => $this->user_id,
            'therapist_id' => $this->id,
            'email' => $this->user->email,
            'username' => $this->user->username,
            'therapist_name' => $this->therapist_name,
            'role' => $this->user->role,
            'therapist_section' => $this->therapist_section,
            'therapist_phone' => $this->therapist_phone,
            'status' => $status,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];

        return $response;
    }
}
