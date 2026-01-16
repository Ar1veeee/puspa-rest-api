<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentListAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $child = $this->child;
        $guardian = $this->child?->family?->guardians?->first();
        $details = $this->assessmentDetails;

        $scheduled = $this->scheduled_date instanceof Carbon
            ? $this->scheduled_date
            : Carbon::parse($this->scheduled_date);

        $completedDetail = $details->whereNotNull('completed_at')->first();
        $completedAtStr = 'Belum Selesai';

        if ($completedDetail) {
            $date = $completedDetail->completed_at instanceof Carbon
                ? $completedDetail->completed_at
                : Carbon::parse($completedDetail->completed_at);
            $completedAtStr = $date->format('H.i');
        }

        $types = $details->map(function ($detail) {
            return match ($detail->type) {
                'umum' => 'Assessment Umum',
                'fisio' => 'Assessment Fisio',
                'okupasi' => 'Assessment Okupasi',
                'wicara' => 'Assessment Wicara',
                'paedagog' => 'Assessment Paedagog',
                default => 'Assessment Tidak Dikenal',
            };
        })->unique()->values()->toArray();

        $assessors = $details->map(function ($detail) {
            if ($detail->type === 'umum') {
                return 'Orang Tua';
            }

            return $detail->therapist?->therapist_name ?? 'Belum Ditentukan';
        })->implode(', ');

        $adminName = $details->first()?->admin?->admin_name;

        return [
            'id' => $this->id,
            'assessment_id' => $this->id,
            'child_id' => $child?->id,
            'child_name' => $child?->child_name,
            'guardian_name' => $guardian?->guardian_name,
            'guardian_phone' => $guardian?->guardian_phone,
            'type' => $types,
            'administrator' => $adminName,
            'assessor' => $assessors ?: null,
            'scheduled_date' => $scheduled->format('d/m/Y'),
            'scheduled_time' => $scheduled->format('H.i'),
            'completed_at' => $completedAtStr,
            'status' => $this->status,
        ];
    }
}
