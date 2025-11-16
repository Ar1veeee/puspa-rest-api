<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentScheduledDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $child = $this->assessment->child;

        $guardian = $this->assessment->child?->family?->guardians?->first();

        $scheduled_date_formatted = $this->scheduled_date instanceof Carbon
            ? $this->scheduled_date
            : Carbon::parse($this->scheduled_date);

        $allDetails = $this->assessment->assessmentDetails;

        $allTypes = $allDetails->map(function ($detail) {
            return match ($detail->type) {
                'fisio' => 'Assessment Fisio',
                'wicara' => 'Assessment Wicara',
                'okupasi' => 'Assessment Okupasi',
                'paedagog' => 'Assessment Paedagog',
                default => ucfirst($detail->type),
            };
        });

        $typesString = $allTypes->implode(', ');

        return [
            "observation_id" => $this->id,
            'child_name' => $child->child_name,
            'child_birth_date' => $child->child_birth_date->translatedFormat('d F Y'),
            'child_age' => $child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $child->child_gender,
            'child_school' => $child->child_school,
            'child_address' => $child->child_address,
            'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'), // Hanya tanggal
            'scheduled_time' => $scheduled_date_formatted->format('H:i'), // Hanya jam:menit
            'parent_type' => $guardian->guardian_type,
            'parent_name' => $guardian->guardian_name,
            'relationship' => $guardian->relationship_with_child,
            'parent_phone' => $guardian->guardian_phone,
            'admin_name' => $this->admin->admin_name,
            'type' => $typesString,
        ];
    }
}
