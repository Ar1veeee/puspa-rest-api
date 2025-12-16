<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationScheduledDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $guardian = $this->child?->family?->guardians?->first();

        $scheduled_date_formatted = $this->scheduled_date instanceof Carbon
            ? $this->scheduled_date
            : Carbon::parse($this->scheduled_date);

        return [
            "observation_id" => $this->id,
            'child_name' => $this->child->child_name,
            'child_birth_date' => $this->child->child_birth_date->translatedFormat('d F Y'),
            'child_age' => $this->child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child->child_gender,
            'child_school' => $this->child->child_school,
            'child_address' => $this->child->child_address,
            'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'), // Only date
            'scheduled_time' => $scheduled_date_formatted->format('H:i'), // Only hour:minute
            'parent_type' => $guardian->guardian_type,
            'parent_name' => $guardian->guardian_name,
            'relationship' => $guardian->relationship_with_child,
            'parent_phone' => $guardian->guardian_phone,
            'admin_name' => $this->admin->admin_name,
            'child_complaint' => $this->child->child_complaint,
            'child_service_choice' => $this->child->child_service_choice,
        ];
    }
}
