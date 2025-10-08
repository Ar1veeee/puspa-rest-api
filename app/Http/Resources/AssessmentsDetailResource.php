<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentsDetailResource extends JsonResource
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
            'observation_id' => $this->observation_id,
            'child_id' => $this->child_id,
            'fisio' => $this->fisio,
            'okupasi' => $this->okupasi,
            'wicara' => $this->wicara,
            'paedagog' => $this->paedagog,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'status' => $this->status,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];
    }
}
