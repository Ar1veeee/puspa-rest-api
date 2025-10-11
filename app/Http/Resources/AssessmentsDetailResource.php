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
            'assessment_id' => $this->id,
            'observation_id' => $this->observation_id,
            'child_id' => $this->child_id,
            'physio' => $this->fisio,
            'occupation' => $this->okupasi,
            'speech' => $this->wicara,
            'pedagogical' => $this->paedagog,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'status' => $this->status,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];
    }
}
