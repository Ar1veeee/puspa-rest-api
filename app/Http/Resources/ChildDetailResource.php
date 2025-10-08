<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'child_name' => $this->child_name,
            'child_birth_info' => $this->child_birth_place . ', ' . $this->child_birth_date->format('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child_gender,
            'child_religion' => $this->child_religion ?? '-',
            'child_school' => $this->child_school,
            'child_address' => $this->child_address,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),

            'father_name' => '-',
            'father_phone' => '-',
            'father_age' => '-',
            'father_occupation' => '-',
            'father_relationship' => '-',

            'mother_name' => '-',
            'mother_phone' => '-',
            'mother_age' => '-',
            'mother_occupation' => '-',
            'mother_relationship' => '-',

            'guardian_name' => '-',
            'guardian_phone' => '-',
            'guardian_age' => '-',
            'guardian_occupation' => '-',
            'guardian_relationship' => '-',

            'child_complaint' => $this->child_complaint,
            'child_service_choice' => $this->child_service_choice,
        ];

        foreach ($this->family?->guardians as $guardian) {
            $age = $guardian->guardian_birth_date
                ? $guardian->guardian_birth_date->diff(now())->format('%y Tahun %m Bulan')
                : '-';

            match ($guardian->guardian_type) {
                'ayah' => [
                    $response['father_name'] = $guardian->guardian_name,
                    $response['father_phone'] = $guardian->guardian_phone,
                    $response['father_age'] = $age,
                    $response['father_occupation'] = $guardian->guardian_occupation ?? '-',
                    $response['father_relationship'] = $guardian->relationship_with_child ?? '-',
                ],
                'ibu' => [
                    $response['mother_name'] = $guardian->guardian_name,
                    $response['mother_phone'] = $guardian->guardian_phone,
                    $response['mother_age'] = $age,
                    $response['mother_occupation'] = $guardian->guardian_occupation ?? '-',
                    $response['mother_relationship'] = $guardian->relationship_with_child ?? '-',
                ],
                'wali' => [
                    $response['wali_name'] = $guardian->guardian_name,
                    $response['wali_phone'] = $guardian->guardian_phone,
                    $response['wali_age'] = $age,
                    $response['wali_occupation'] = $guardian->guardian_occupation ?? '-',
                    $response['wali_relationship'] = $guardian->relationship_with_child ?? '-',
                ],
                default => null,
            };
        }

        return $response;
    }
}
