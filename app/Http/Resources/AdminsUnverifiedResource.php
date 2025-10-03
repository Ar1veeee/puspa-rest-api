<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminsUnverifiedResource extends JsonResource
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
            'admin_id' => $this->admin->id,
            'email' => $this->email,
            'admin_name' => $this->admin->admin_name,
            'admin_phone' => $this->admin->admin_phone,
            'createdAt' => $this->created_at->format('d F Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d F Y H:i:s'),
        ];
    }
}
