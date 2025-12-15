<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'user_id' => $this->resource['user']->id,
            'username' => $this->resource['user']->username,
            'email' => $this->resource['user']->email,
            'role' => $this->resource['user']->role,
            'tokenType' => 'Bearer',
            'token' => $this->resource['token'],
            'expires_at' => now()->addDays(7)->toDateTimeString(),
            'created_at' => $this->resource['user']->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->resource['user']->updated_at->format('Y-m-d H:i'),
        ];
    }
}
