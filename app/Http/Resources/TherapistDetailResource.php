<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TherapistDetailResource",
 *     type="object",
 *     @OA\Property(property="id", type="string", description="Therapist ID"),
 *     @OA\Property(property="user_id", type="string", description="User ID"),
 *     @OA\Property(property="email", type="string", format="email", description="Email address"),
 *     @OA\Property(property="username", type="string", description="Username"),
 *     @OA\Property(property="therapist_name", type="string", description="Therapist name"),
 *     @OA\Property(property="therapist_section", type="string", description="Therapist section"),
 *     @OA\Property(property="therapist_phone", type="string", description="Therapist phone number"),
 *     @OA\Property(property="createdAt", type="string", format="date-time", description="Creation date"),
 *     @OA\Property(property="updatedAt", type="string", format="date-time", description="Update date")
 * )
 */
class TherapistDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'email' => $this->email,
            'username' => $this->username,
            'therapist_name' => $this->therapist_name,
            'therapist_section' => $this->therapist_section,
            'therapist_phone' => $this->therapist_phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
