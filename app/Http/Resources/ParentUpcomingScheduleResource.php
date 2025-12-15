<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentUpcomingScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['id'],
            'child_name' => $this->resource['child_name'],
            'service_type' => $this->resource['type_label'],
            'status' => $this->resource['status_label'],
            'date' => $this->resource['date'],
            'time' => $this->resource['time'],
            'therapist' => $this->resource['therapist'],
        ];
    }
}
