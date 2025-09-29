<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 * schema="ObservationScheduledDetailResource",
 * type="object",
 * @OA\Property(property="id", type="integer", description="Observation ID"),
 * @OA\Property(property="child_name", type="string", description="Nama lengkap anak"),
 * @OA\Property(property="child_birth_date", type="string", format="date", description="Tanggal lahir anak"),
 * @OA\Property(property="child_age", type="integer", description="Usia anak saat ini"),
 * @OA\Property(property="child_gender", type="string", description="Jenis kelamin anak"),
 * @OA\Property(property="child_school", type="string", nullable=true, description="Sekolah anak"),
 * @OA\Property(property="child_address", type="string", description="Alamat rumah anak"),
 * @OA\Property(property="scheduled_date", type="string", format="date", description="Tanggal jadwal observasi"),
 * @OA\Property(property="parent_name", type="string", description="Nama wali"),
 * @OA\Property(property="parent_type", type="string", description="Tipe wali (cth: ayah, ibu)"),
 * @OA\Property(property="parent_phone", type="string", description="Nomor telepon wali"),
 * @OA\Property(property="child_complaint", type="string", description="Keluhan awal anak"),
 * @OA\Property(property="child_service_choice", type="string", description="Pilihan layanan untuk anak")
 * )
 */
class ObservationScheduledDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $guardian = $this->child?->family?->guardians?->first();

        return [
            "id" => $this->id,
            'child_name' => $this->child->child_name,
            'child_birth_date' => $this->child->child_birth_date->format('d F Y'),
            'child_age' => $this->child->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child->child_gender,
            'child_school' => $this->child->child_school,
            'child_address' => $this->child->child_address,
            'scheduled_date' => $this->scheduled_date->toDateString(),
            'parent_name' => $guardian->guardian_name,
            'parent_type' => $guardian->guardian_type,
            'parent_phone' => $guardian->guardian_phone,
            'child_complaint' => $this->child->child_complaint,
            'child_service_choice' => $this->child->child_service_choice,
        ];
    }
}
