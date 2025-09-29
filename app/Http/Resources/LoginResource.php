<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="LoginResource",
 * type="object",
 * @OA\Property(property="id", type="string", description="User ID"),
 * @OA\Property(property="username", type="string", description="Username"),
 * @OA\Property(property="email", type="string", format="email", description="Email address"),
 * @OA\Property(property="role", type="string", description="User role"),
 * @OA\Property(property="token_type", type="string", example="Bearer"),
 * @OA\Property(property="access_token", type="string", description="Authentication token"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp")
 * )
 */
class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['user']->id,
            'username' => $this->resource['user']->username,
            'email' => $this->resource['user']->email,
            'role' => $this->resource['user']->role,
            'tokenType' => 'Bearer',
            'token' => $this->resource['token'],
            'expires_at' => now()->addDays(7)->toDateTimeString(),
            'created_at' => $this->resource['user']->created_at,
            'updated_at' => $this->resource['user']->updated_at,
        ];
    }
}
