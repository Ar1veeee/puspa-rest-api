<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
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
                'fisio'     => 'Assessment Fisio',
                'okupasi'   => 'Assessment Okupasi',
                'wicara'    => 'Assessment Wicara',
                'paedagog'  => 'Assessment Paedagog',
                'umum'      => 'Assessment Umum',
                default     => 'Assessment Tidak Dikenal',
            };
        })->unique()->values()->toArray();

        $assessors = $details->map(fn($detail) => $detail->therapist?->therapist_name)
            ->filter()
            ->unique()
            ->implode(', ');

        $adminName = $details->first()?->admin?->admin_name;

        $firstDetailId = $details->first()?->id;

        return [
            'assessment_detail_id' => $firstDetailId,
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
