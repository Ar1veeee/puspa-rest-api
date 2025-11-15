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
            $types[] = 'Fisio';
        }
        if ($this->wicara) {
            $types[] = 'Wicara';
        }
        if ($this->paedagog) {
            $types[] = 'Paedagog';
        }
        if ($this->okupasi) {
            $types[] = 'Okupasi';
        }

        $type = implode(', ', $types);

        $response = [
            "assessment_id" => $this->id,
            'administrator' => $this->admin?->admin_name,
            'child_name' => $this->child->child_name,
            'child_gender' => $this->child->child_gender,
            'child_age' => $this->child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_school' => $this->child->child_school,
            'assessment_type' => $type,
            'status' => $this->status,
            'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'), // Hanya tanggal
            'scheduled_time' => $scheduled_date_formatted->format('H.i'), // Hanya jam:menit
        ];

        return $response;
    }
}
