<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="TherapistResource",
 * type="object",
 * @OA\Property(property="id", type="string", description="Therapist ID"),
 * @OA\Property(property="user_id", type="string", description="User ID terkait"),
 * @OA\Property(property="email", type="string", format="email", description="Email terapis"),
 * @OA\Property(property="username", type="string", description="Username terapis"),
 * @OA\Property(property="therapist_name", type="string", description="Nama lengkap terapis"),
 * @OA\Property(property="therapist_section", type="string", description="Bagian/spesialisasi terapis"),
 * @OA\Property(property="therapist_phone", type="string", description="Nomor telepon terapis"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
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
            'therapist_section' => $this->therapist_section,
            'therapist_phone' => $this->therapist_phone,
            'status' => $status,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];

        return $response;
    }
}
