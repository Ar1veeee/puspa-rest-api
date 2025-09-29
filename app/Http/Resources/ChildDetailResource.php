<?php

namespace App\Http\Resources;

use App\Models\Child;
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
        // $age = null;
        // if ($this->child && $this->child->child_birth_date) {
        //     $ageInfo = Child::calculateAgeAndCategory($this->child->child_birth_date);
        //     $age = $ageInfo['age'];
        // }

        $response = [
            'child_name' => $this->child_name,
            'child_birth_info' => $this->child_birth_place . ', ' . $this->child_birth_date->format('d F Y'),
            'child_age' => $this->child_birth_date->diff(now())->format('%y Tahun %m Bulan'),
            // 'child_age' => $age,
            'child_gender' => $this->child_gender,
            'child_religion' => $this->child_religion ?? '-',
            'child_school' => $this->child_school,
            'child_address' => $this->child_address,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),

            'father_name' => '-',
            'father_relationship' => '-',
            'father_age' => '-',
            'father_occupation' => '-',
            'father_phone' => '-',

            'mother_name' => '-',
            'mother_relationship' => '-',
            'mother_age' => '-',
            'mother_occupation' => '-',
            'mother_phone' => '-',

            'guardian_name' => '-',
            'guardian_relationship' => '-',
            'guardian_age' => '-',
            'guardian_occupation' => '-',
            'guardian_phone' => '-',

            'child_complaint' => $this->child_complaint,
            'child_service_choice' => $this->child_service_choice,
        ];

        foreach ($this->family?->guardians as $guardian) {
            match ($guardian->guardian_type) {
                'ayah' => [
                    $response['father_name'] = $guardian->guardian_name,
                    $response['father_relationship'] = $guardian->relationship_with_child ?? '-',
                    $response['father_age'] = $guardian->guardian_age ?? '-',
                    $response['father_occupation'] = $guardian->guardian_occupation ?? '-',
                    $response['father_phone'] = $guardian->guardian_phone,
                ],
                'ibu' => [
                    $response['mother_name'] = $guardian->guardian_name,
                    $response['mother_relationship'] = $guardian->relationship_with_child ?? '-',
                    $response['mother_age'] = $guardian->guardian_age,
                    $response['mother_occupation'] = $guardian->guardian_occupation ?? '-',
                    $response['mother_phone'] = $guardian->guardian_phone,
                ],
                'wali' => [
                    $response['wali_name'] = $guardian->guardian_name,
                    $response['wali_relationship'] = $guardian->relationship_with_child ?? '-',
                    $response['wali_age'] = $guardian->guardian_age,
                    $response['wali_occupation'] = $guardian->guardian_occupation ?? '-',
                    $response['wali_phone'] = $guardian->guardian_phone,
                ],
                default => null,
            };
        }

        return $response;
    }
}
