<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentDashboardStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_children' => [
                'count' => $this->resource['total_children'],
                'percentage' => $this->resource['total_children_percentage']['value'],
                'direction' => $this->resource['total_children_percentage']['direction'],
                'label' => $this->getPercentageLabel($this->resource['total_children_percentage']),
            ],
            'total_observations' => [
                'count' => $this->resource['total_observations'],
                'percentage' => $this->resource['total_observations_percentage']['value'],
                'direction' => $this->resource['total_observations_percentage']['direction'],
                'label' => $this->getPercentageLabel($this->resource['total_observations_percentage']),
            ],
            'total_assessments' => [
                'count' => $this->resource['total_assessments'],
                'percentage' => $this->resource['total_assessments_percentage']['value'],
                'direction' => $this->resource['total_assessments_percentage']['direction'],
                'label' => $this->getPercentageLabel($this->resource['total_assessments_percentage']),
            ],
        ];
    }

    private function getPercentageLabel(array $percentage): string
    {
        $direction = $percentage['direction'];
        $value = $percentage['value'];

        if ($direction === 'neutral' || $value == 0) {
            return 'tidak ada perubahan';
        }

        $prefix = $direction === 'up' ? '+' : '-';
        return "{$prefix}{$value}% dari bulan lalu";
    }
}
