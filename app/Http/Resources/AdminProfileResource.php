<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AdminProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = $this->user->role === 'admin' ? 'Admin' : '';

        return [
            'user_id' => $this->user_id,
            'admin_id' => $this->id,
            'admin_name' => $this->admin_name,
            'admin_phone' => $this->admin_phone,
            'admin_birth_date' => $this->admin_birth_date->format('Y-m-d'),
            'email' => $this->user->email,
            'role' => $role,
            'profile_picture' => $this->profile_picture
            ? Storage::url($this->profile_picture)
                : null,
        ];
    }
}
