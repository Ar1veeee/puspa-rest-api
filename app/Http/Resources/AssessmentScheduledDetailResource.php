<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentScheduledDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $this->loadMissing([
            'assessmentDetails.admin',
            'child',
            'child.family.guardians'
        ]);

        $child = $this->child;
        $guardian = $this->child?->family?->guardians?->first();

        $admin = $this->assessmentDetails->firstWhere('admin_id', '!=', null)?->admin
            ?? $this->assessmentDetails->first()?->admin
            ?? null;

        $scheduledDate = $this->assessmentDetails->first()?->scheduled_date;

        $scheduled_date_formatted = $scheduledDate
            ? (is_string($scheduledDate) ? Carbon::parse($scheduledDate) : $scheduledDate)
            : null;

        $allTypes = $this->assessmentDetails->pluck('type')->map(function ($type) {
            return match ($type) {
                'fisio'     => 'Assessment Fisio',
                'wicara'    => 'Assessment Wicara',
                'okupasi'   => 'Assessment Okupasi',
                'paedagog'  => 'Assessment Paedagog',
                'umum'      => 'Assessment Umum',
                default     => ucfirst($type),
            };
        });

        $typesString = $allTypes->implode(', ');

        return [
            'assessment_id'     => $this->id,
            'child_name'        => $child?->child_name,
            'child_birth_date'  => $child?->child_birth_date?->translatedFormat('d F Y'),
            'child_age'         => $child?->child_birth_date?->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender'      => $child?->child_gender,
            'child_school'      => $child?->child_school,
            'child_address'     => $child?->child_address,
            'scheduled_date'    => $scheduled_date_formatted?->format('d/m/Y'),
            'scheduled_time'    => $scheduled_date_formatted?->format('H:i'),
            'parent_type'       => $guardian?->guardian_type,
            'parent_name'       => $guardian?->guardian_name,
            'relationship'      => $guardian?->relationship_with_child,
            'parent_phone'      => $guardian?->guardian_phone,
            'admin_name'        => $admin?->admin_name ?? 'Belum ditentukan',
            'type'              => $typesString ?: 'Belum ditentukan',
        ];
    }
}
