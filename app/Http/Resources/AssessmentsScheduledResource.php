<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentsScheduledResource extends JsonResource
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

        $types = [];

        if ($this->fisio) {
            $types[] = 'Asesmen Fisio';
        }
        if ($this->wicara) {
            $types[] = 'Asesmen Wicara';
        }
        if ($this->paedagog) {
            $types[] = 'Asesmen Paedagog';
        }
        if ($this->okupasi) {
            $types[] = 'Asesmen Okupasi';
        }

        $type = implode(', ', $types);

        $primaryGuardian = $this->child->family->guardians->first();

        $response = [
            "assessment_id" => $this->id,
            'child_name' => $this->child->child_name,
            'guardian_name' => $primaryGuardian->guardian_name,
            'guardian_phone' => $primaryGuardian->guardian_phone,
            'assessment_type' => $type,
            'administrator' => $this->admin?->admin_name,
            'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'), // Hanya tanggal
            'scheduled_time' => $scheduled_date_formatted->format('H.i'), // Hanya jam:menit
            'status' => $this->status,
        ];

        return $response;
    }
}
