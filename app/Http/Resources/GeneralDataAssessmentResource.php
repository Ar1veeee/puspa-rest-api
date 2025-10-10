<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralDataAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $assessmentDetails = $this->resource['assessment_details'];
        $psychosocial = $this->resource['psychosocial'];
        $pregnancy = $this->resource['pregnancy'];
        $birth = $this->resource['birth'];
        $postBirth = $this->resource['post_birth'];
        $health = $this->resource['health'];
        $education = $this->resource['education'];

        $response = [
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

            'child_order' => $psychosocial?->child_order,
            'siblings' => $psychosocial?->siblings,
            'household_members' => $psychosocial?->household_members,
            'parent_marriage_status' => $psychosocial?->parent_marriage_status,
            'daily_language' => $psychosocial?->daily_language,

            'pregnancy_desired' => $pregnancy?->pregnancy_desired,
            'routine_checkup' => $pregnancy?->routine_checkup,
            'mother_age_at_pregnancy' => $pregnancy?->mother_age_at_pregnancy,
            'pregnancy_duration' => $pregnancy?->pregnancy_duration,
            'pregnancy_hemoglobin' => $pregnancy?->pregnancy_hemoglobin,
            'pregnancy_incidents' => $pregnancy?->pregnancy_incidents,
            'medication_consumption' => $pregnancy?->medication_consumption,
            'pregnancy_complications' => $pregnancy?->pregnancy_complications,

            'birth_type' => $birth?->birth_type,
            'if_normal' => $birth?->if_normal,
            'caesar_vacuum_reason' => $birth?->caesar_vacuum_reason,
            'crying_immediately' => $birth?->crying_immediately,
            'birth_condition' => $birth?->birth_condition,
            'birth_condition_duration' => $birth?->birth_condition_duration,
            'incubator_used' => $birth?->incubator_used,
            'incubator_duration' => $birth?->incubator_duration,
            'birth_weight' => $birth?->birth_weight,
            'birth_length' => $birth?->birth_length,
            'head_circumference' => $birth?->head_circumference,
            'birth_complications_other' => $birth?->birth_complications_other,
            'postpartum_depression' => $birth?->postpartum_depression,

            'postbirth_condition' => $postBirth?->postbirth_condition,
            'postbirth_condition_duration' => $postBirth?->postbirth_condition_duration,
            'postbirth_condition_age' => $postBirth?->postbirth_condition_age,
            'has_ever_fallen' => $postBirth?->has_ever_fallen,
            'injured_body_part' => $postBirth?->injured_body_part,
            'age_at_fall' => $postBirth?->age_at_fall,
            'other_postbirth_complications' => $postBirth?->other_postbirth_complications,
            'head_lift_age' => $postBirth?->head_lift_age,
            'prone_age' => $postBirth?->prone_age,
            'roll_over_age' => $postBirth?->roll_over_age,
            'sitting_age' => $postBirth?->sitting_age,
            'crawling_age' => $postBirth?->crawling_age,
            'climbing_age' => $postBirth?->climbing_age,
            'standing_age' => $postBirth?->standing_age,
            'walking_age' => $postBirth?->walking_age,
            'complete_immunization' => $postBirth?->complete_immunization,
            'uncompleted_immunization_detail' => $postBirth?->uncompleted_immunization_detail,
            'exclusive_breastfeeding' => $postBirth?->exclusive_breastfeeding,
            'exclusive_breastfeeding_until_age' => $postBirth?->exclusive_breastfeeding_until_age,
            'rice_intake_age' => $postBirth?->rice_intake_age,

            'allergies_age' => $health?->allergies_age,
            'fever_age' => $health?->fever_age,
            'ear_infections_age' => $health?->ear_infections_age,
            'headaches_age' => $health?->headaches_age,
            'mastoiditis_age' => $health?->mastoiditis_age,
            'sinusitis_age' => $health?->sinusitis_age,
            'asthma_age' => $health?->asthma_age,
            'seizures_age' => $health?->seizures_age,
            'encephalitis_age' => $health?->encephalitis_age,
            'high_fever_age' => $health?->high_fever_age,
            'meningitis_age' => $health?->meningitis_age,
            'tonsillitis_age' => $health?->tonsillitis_age,
            'chickenpox_age' => $health?->chickenpox_age,
            'dizziness_age' => $health?->dizziness_age,
            'measles_or_rubella_age' => $health?->measles_or_rubella_age,
            'influenza_age' => $health?->influenza_age,
            'pneumonia_age' => $health?->pneumonia_age,
            'others' => $health?->others,
            'family_similar_conditions_detail' => $health?->family_similar_conditions_detail,
            'family_mental_disorders' => $health?->family_mental_disorders,
            'child_surgeries_detail' => $health?->child_surgeries_detail,
            'special_medical_conditions' => $health?->special_medical_conditions,
            'other_medications_detail' => $health?->other_medications_detail,
            'negative_reactions_detail' => $health?->negative_reactions_detail,
            'hospitalization_history' => $health?->hospitalization_history,

            'currently_in_school' => $education?->currently_in_school,
            'school_location' => $education?->school_location,
            'school_class' => $education?->school_class,
            'long_absence_from_school' => $education?->long_absence_from_school,
            'long_absence_reason' => $education?->long_absence_reason,
            'academic_and_socialization_detail' => $education?->academic_and_socialization_detail,
            'special_treatment_detail' => $education?->special_treatment_detail,
            'learning_support_program' => $education?->learning_support_program,
            'learning_support_detail' => $education?->learning_support_detail,
        ];

        $guardians = $assessmentDetails?->child?->family?->guardians;

        if ($guardians) {
            foreach ($guardians as $guardian) {
                $age = $guardian->guardian_birth_date
                    ? Carbon::parse($guardian->guardian_birth_date)->diff(now())->format('%y Tahun %m Bulan')
                    : null;

                switch ($guardian->guardian_type) {
                    case 'ayah':
                        $response['father_name'] = $guardian->guardian_name;
                        $response['father_phone'] = $guardian->guardian_phone;
                        $response['father_age'] = $age;
                        $response['father_occupation'] = $guardian->guardian_occupation;
                        $response['father_relationship'] = $guardian->relationship_with_child;
                        break;
                    case 'ibu':
                        $response['mother_name'] = $guardian->guardian_name;
                        $response['mother_phone'] = $guardian->guardian_phone;
                        $response['mother_age'] = $age;
                        $response['mother_occupation'] = $guardian->guardian_occupation;
                        $response['mother_relationship'] = $guardian->relationship_with_child;
                        break;
                    case 'wali':
                        $response['guardian_name'] = $guardian->guardian_name;
                        $response['guardian_phone'] = $guardian->guardian_phone;
                        $response['guardian_age'] = $age;
                        $response['guardian_occupation'] = $guardian->guardian_occupation;
                        $response['guardian_relationship'] = $guardian->relationship_with_child;
                        break;
                };
            }
        }

        return $response;
    }
}
