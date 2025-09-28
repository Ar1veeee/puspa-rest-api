<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="AdminResource",
 * type="object",
 * @OA\Property(property="id", type="string", description="Admin profile ID"),
 * @OA\Property(property="user_id", type="string", description="User ID terkait"),
 * @OA\Property(property="email", type="string", format="email", description="Email admin"),
 * @OA\Property(property="username", type="string", description="Username admin"),
 * @OA\Property(property="admin_name", type="string", description="Nama lengkap admin"),
 * @OA\Property(property="admin_phone", type="string", description="Nomor telepon admin"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class AdminsResource extends JsonResource
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
            'email' => $this->user['email'] ?? null,
            'username' => $this->user['username'] ?? null,
            'admin_name' => $this['admin_name'] ?? null,
            'admin_phone' => $this['admin_phone'] ?? null,
            'createdAt' => $this['created_at'] ?? null,
            'updatedAt' => $this['updated_at'] ?? null,
        ];
    }
}
