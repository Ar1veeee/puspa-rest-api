<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildrenAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $detail = $this->assessment?->assessmentDetails
            ->where('status', 'scheduled')
            ->sortBy('scheduled_date')
            ->first();

        $reportData = [
            'available' => false,
            'uploaded_at' => null,
            'download_url' => null
        ];

        if ($this->assessment && $this->assessment->report_file) {
            $reportData = [
                'available' => true,
                'uploaded_at' => $this->assessment->report_uploaded_at?->format('d/m/Y H:i'),
                'download_url' => route('parent.assessment.report.download', $this->assessment->id)
            ];
        }

        return [
            'assessment_id' => $detail?->assessment_id,
            'child_id' => $this->id,
            'family_id' => $this->family_id,
            'child_name' => $this->child_name,
            'child_birth_info' => $this->child_birth_place . ', ' . $this->child_birth_date->translatedFormat('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child_gender,
            'child_school' => $this->child_school,
            'scheduled_date' => $detail?->scheduled_date?->toDateString(),
            'status' => $detail?->status,
            'created_at' => $detail?->created_at?->format('d F Y H:i:s'),
            'updated_at' => $detail?->updated_at?->format('d F Y H:i:s'),
            'report' => $reportData,
        ];
    }
}
