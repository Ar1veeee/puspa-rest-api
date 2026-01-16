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
        $assessment = $this->assessment;

        if ($assessment && $assessment->report_file) {
            $reportData = [
                'available' => true,
                'uploaded_at' => $assessment->report_uploaded_at?->format('d/m/Y H:i'),
                'download_url' => route('parent.assessment.report.download', $assessment->id)
            ];
        }

        $scheduledDate = $assessment?->scheduled_date instanceof \Carbon\Carbon
            ? $assessment->scheduled_date
            : \Carbon\Carbon::parse($assessment?->scheduled_date);

        return [
            'assessment_id' => $assessment?->id,
            'scheduled_date' => $assessment ? $scheduledDate->toDateString() : null,
            'status' => $assessment?->status,
            'created_at' => $assessment?->created_at?->format('d F Y H:i:s'),
            'updated_at' => $assessment?->updated_at?->format('d F Y H:i:s'),
            'child_id' => $this->id,
            'family_id' => $this->family_id,
            'child_name' => $this->child_name,
            'child_birth_info' => $this->child_birth_place . ', ' . $this->child_birth_date->translatedFormat('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child_gender,
            'child_school' => $this->child_school,
        ];
    }
}
