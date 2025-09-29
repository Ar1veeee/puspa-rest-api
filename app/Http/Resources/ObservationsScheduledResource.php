<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="ObservationsScheduledResource",
 * type="object",
 * @OA\Property(property="id", type="integer", description="Observation ID"),
 * @OA\Property(property="age_category", type="string", description="Kategori usia saat observasi"),
 * @OA\Property(property="child_name", type="string", description="Nama anak"),
 * @OA\Property(property="child_gender", type="string", description="Jenis kelamin anak"),
 * @OA\Property(property="child_age", type="integer", description="Usia anak (tahun)"),
 * @OA\Property(property="child_school", type="string", nullable=true, description="Sekolah anak"),
 * @OA\Property(property="scheduled_date", type="string", format="date", description="Tanggal jadwal observasi"),
 * @OA\Property(property="status", type="string", example="Scheduled", description="Status observasi")
 * )
 */
class ObservationsScheduledResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'age_category' => $this->age_category,
            'child_name' => $this->child->child_name,
            'child_gender' => $this->child->child_gender,
            'child_age' => $this->child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_school' => $this->child->child_school,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'status' => $this->status,
        ];
    }
}
