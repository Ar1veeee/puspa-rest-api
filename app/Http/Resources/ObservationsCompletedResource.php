<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="ObservationsCompletedResource",
 * type="object",
 * @OA\Property(property="id", type="integer", description="Observation ID"),
 * @OA\Property(property="age_category", type="string", description="Kategori usia saat observasi"),
 * @OA\Property(property="child_name", type="string", description="Nama anak"),
 * @OA\Property(property="observer", type="string", description="Nama terapis yang mengobservasi"),
 * @OA\Property(property="child_age", type="integer", description="Usia anak saat observasi"),
 * @OA\Property(property="child_school", type="string", nullable=true, description="Sekolah anak"),
 * @OA\Property(property="scheduled_date", type="string", format="date", description="Tanggal observasi dilakukan"),
 * @OA\Property(property="status", type="string", example="Completed")
 * )
 */
class ObservationsCompletedResource extends JsonResource
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

        $completed_at_formatted = $this->completed_at instanceof Carbon
            ? $this->completed_at
            : Carbon::parse($this->completed_at);

        $primaryGuardian = $this->child->family->guardians->first();

        $response = [
            "observation_id" => $this->id,
            'age_category' => $this->age_category,
            'child_name' => $this->child->child_name,
            'guardian_name' => $primaryGuardian->guardian_name,
            'guardian_phone' => $primaryGuardian->guardian_phone,
            'observer' => $this->therapist->therapist_name,
            'scheduled_date' => $scheduled_date_formatted->format('d/m/Y'),
            'time' => $scheduled_date_formatted->format('H.i') . ' - ' . $completed_at_formatted->format('H.i'),
            'status' => $this->status,
        ];

        return $response;
    }
}
