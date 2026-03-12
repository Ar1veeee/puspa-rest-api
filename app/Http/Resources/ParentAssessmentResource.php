<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentAssessmentResource extends JsonResource
{
    public function toArray($request)
    {
        $details = $this->whenLoaded('assessmentDetails', function () {
            return $this->assessmentDetails;
        }, function () {
            return collect();
        });

        $types = $details->pluck('type')->map(fn($type) => match ($type) {
            'fisio' => 'Assessment Fisio',
            'okupasi' => 'Assessment Okupasi',
            'wicara' => 'Assessment Wicara',
            'paedagog' => 'Assessment Paedagog',
            'umum' => 'Assessment Umum',
            default => ucfirst($type),
        })->unique()->sort()->values();

        $primaryGuardian = null;
        if ($this->child && $this->child->family && $this->child->family->guardians) {
            $primaryGuardian = $this->child->family->guardians
                ->sortByDesc(fn($g) => in_array($g->guardian_type, ['ayah', 'ibu']) ? 1 : 0)
                ->first();
        };

        $earliestDate = $this->min('scheduled_date');
        $formattedScheduledDate = $earliestDate ? Carbon::parse($earliestDate)->format('d/m/Y') : null;
        $formattedScheduledTime = $earliestDate ? Carbon::parse($earliestDate)->format('H:i') : null;

        $parentCompleted = $details->first()?->parent_completed_at;
        $formattedParentCompletedTime = $parentCompleted ? Carbon::parse($parentCompleted)->format('H:i') : null;

        $adminName = $details->first()?->admin?->admin_name;

        $childDeleted = $this->child?->trashed() ?? false;

        return [
            'assessment_id' => $this->id,
            'child_name' => $this->child->child_name ?? 'N/A',
            'child_deleted' => $childDeleted,
            'guardian_name' => $primaryGuardian?->guardian_name,
            'guardian_phone' => $primaryGuardian?->guardian_phone,
            'types' => $types,
            'scheduled_date' => $formattedScheduledDate,
            'scheduled_time' => $formattedScheduledTime,
            'admin_name' => $adminName,
            'parent_completed_time' => $formattedParentCompletedTime,
        ];
    }
}
