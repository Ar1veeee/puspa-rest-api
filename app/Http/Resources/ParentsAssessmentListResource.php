<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentsAssessmentListResource extends JsonResource
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

        $completed_at_formatted = null;
        if ($this->parent_completed_at) {
            $completed_at_formatted = $this->parent_completed_at instanceof Carbon
                ? $this->parent_completed_at
                : Carbon::parse($this->parent_completed_at);
        }

        $child = $this->assessment?->child;

        $guardian = $this->assessment?->child?->family?->guardians?->first();

        $type = $this->type;

        $types = [];

        if ($type === 'umum') {
            $types = 'Asesmen Umum';
        }
        if ($type === 'fisio') {
            $types = 'Asesmen Fisio';
        }
        if ($type === 'wicara') {
            $types = 'Asesmen Wicara';
        }
        if ($type === 'okupasi') {
            $types = 'Asesmen Okupasi';
        }
        if ($type === 'paedagog') {
            $types = 'Asesmen Paedagog';
        }

        return [
            'id' => $this->id,
            'assessment_id' => $this->assessment->id,
            'child_name' => $child?->child_name,
            'guardian_name' => $guardian?->guardian_name,
            'guardian_phone' => $guardian?->guardian_phone,
            'type' => $types,
            'administrator' => $this->admin?->admin_name,
            'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'), // Hanya tanggal
            'scheduled_time' => $scheduled_date_formatted->format('H.i'), // Hanya jam:menit
            'parent_completed_at' => $completed_at_formatted?->format('H.i'), // Hanya jam:menit
            'status' => $this->status,
        ];
    }
}
