<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationsScheduledResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $scheduled_date_formatted = $this->scheduled_date instanceof Carbon
            ? $this->scheduled_date
            : Carbon::parse($this->scheduled_date);

        $primaryGuardian = $this->child->family->guardians->first();

        $response = [
            "observation_id" => $this->id,
            'age_category' => $this->age_category,
            'child_name' => $this->child->child_name,
            'child_age' => $this->child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'guardian_name' => $primaryGuardian->guardian_name,
            'guardian_phone' => $primaryGuardian->guardian_phone,
            'administrator' => $this->admin?->admin_name,
            'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'), // Only date
            'scheduled_time' => $scheduled_date_formatted->format('H.i'), // Only hour:minute
            'status' => $this->status,
        ];

        return $response;
    }
}
