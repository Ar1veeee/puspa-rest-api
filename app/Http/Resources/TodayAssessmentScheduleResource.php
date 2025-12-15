<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TodayAssessmentScheduleResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($group) {
            $first = $group->first();

            $types = $group->pluck('type')
                ->map(fn($type) => match (strtolower(trim($type))) {
                    'fisio'     => 'Assessment Fisio',
                    'okupasi'   => 'Assessment Okupasi',
                    'wicara'    => 'Assessment Terapi',
                    'paedagog'  => 'Assessment Paedagog',
                    'umum'      => 'Assessment Umum',
                    default     => null,
                })
                ->filter()
                ->unique()
                ->values();

            return [
                'assessment_id'   => $first->assessment_id,
                'child_name'      => $first->child_name,
                'types'           => $types,
                'scheduled_date'  => $first->schedule_date,
                'time'            => $first->waktu,
            ];
        })->values()->toArray();
    }
}
