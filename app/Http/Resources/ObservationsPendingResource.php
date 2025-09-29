<?php

namespace App\Http\Resources;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="ObservationsPendingResource",
 * type="object",
 * @OA\Property(property="id", type="integer", description="Observation ID"),
 * @OA\Property(property="child_name", type="string", description="Nama anak"),
 * @OA\Property(property="child_age", type="integer", description="Usia anak (tahun)"),
 * @OA\Property(property="child_gender", type="string", description="Jenis kelamin anak"),
 * @OA\Property(property="child_school", type="string", nullable=true, description="Sekolah anak"),
 * @OA\Property(property="guardian_name", type="string", description="Nama wali"),
 * @OA\Property(property="guardian_phone", type="string", description="Nomor telepon wali"),
 * @OA\Property(property="scheduled_date", type="string", format="date", description="Tanggal jadwal observasi"),
 * @OA\Property(property="status", type="string", example="Pending", description="Status observasi")
 * )
 */
class ObservationsPendingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $guardian = $this->child?->family?->guardians?->first();
        $age = null;
        if ($this->child && $this->child->child_birth_date) {
            $ageInfo = Child::calculateAgeAndCategory($this->child->child_birth_date);
            $age = $ageInfo['age'];
        }

        return [
            "id" => $this->id,
            'child_name' => $this->child->child_name,
            'child_age' => $age,
            'child_gender' => $this->child->child_gender,
            'child_school' => $this->child->child_school,
            'guardian_name' => $guardian->guardian_name,
            'guardian_phone' => $guardian->guardian_phone,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'status' => $this->status,
        ];
    }
}
