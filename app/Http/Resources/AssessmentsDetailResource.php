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
        $type = $this->type;

        $types = [];

        if ($type === 'fisio')
        {
            $types = 'Assessment Fisio';
        }
        if ($type === 'wicara')
        {
            $types = 'Assessment Wicara';
        }
        if ($type === 'okupasi')
        {
            $types = 'Assessment Okupasi';
        }
        if ($type === 'paedagog')
        {
            $types = 'Assessment Paedagog';
        }

        return [
            'assessment_id' => $this->assessment_id,
            'observation_id' => $this->assessment->observation_id,
            'child_id' => $this->assessment->child_id,
            'type' => $types,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'status' => $this->status,
            'completed' => $this->parent_completed_at ?? null,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];
    }
}
