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
            'child_birth_info' => $this->child_birth_place . ', ' . $this->child_birth_date->translatedFormat('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            'child_gender' => $this->child_gender,
            'child_religion' => $this->child_religion ?? '-',
            'child_school' => $this->child_school,
            'child_address' => $this->child_address,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),

            'father_identity_name' => '-',
            'father_name' => '-',
            'father_phone' => '-',
            'father_age' => '-',
            'father_occupation' => '-',
            'father_relationship' => '-',

            'mother_identity_name' => '-',
            'mother_name' => '-',
            'mother_phone' => '-',
            'mother_age' => '-',
            'mother_occupation' => '-',
            'mother_relationship' => '-',

            'guardian_identity_name' => '-',
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

            switch ($guardian->guardian_type) {
                case 'ayah':
                    $response['father_identity_name'] = $guardian->guardian_identity_name ?? '-';
                    $response['father_name'] = $guardian->guardian_name;
                    $response['father_phone'] = $guardian->guardian_phone;
                    $response['father_age'] = $age;
                    $response['father_occupation'] = $guardian->guardian_occupation ?? '-';
                    $response['father_relationship'] = $guardian->relationship_with_child ?? '-';
                    break;
                case 'ibu':
                    $response['mother_identity_name'] = $guardian->guardian_identity_name ?? '-';
                    $response['mother_name'] = $guardian->guardian_name;
                    $response['mother_phone'] = $guardian->guardian_phone;
                    $response['mother_age'] = $age;
                    $response['mother_occupation'] = $guardian->guardian_occupation ?? '-';
                    $response['mother_relationship'] = $guardian->relationship_with_child ?? '-';
                    break;
                case 'wali':
                    $response['guardian_identity_name'] = $guardian->guardian_identity_name ?? '-';
                    $response['guardian_name'] = $guardian->guardian_name;
                    $response['guardian_phone'] = $guardian->guardian_phone;
                    $response['guardian_age'] = $age;
                    $response['guardian_occupation'] = $guardian->guardian_occupation ?? '-';
                    $response['guardian_relationship'] = $guardian->relationship_with_child ?? '-';
                    break;
            }
        }

        return $response;
    }
}
