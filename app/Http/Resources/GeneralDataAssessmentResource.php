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
        $response = [
            'father_name' => null, 'father_phone' => null, 'father_age' => null, 'father_occupation' => null, 'father_relationship' => null,
            'mother_name' => null, 'mother_phone' => null, 'mother_age' => null, 'mother_occupation' => null, 'mother_relationship' => null,
            'guardian_name' => null, 'guardian_phone' => null, 'guardian_age' => null, 'guardian_occupation' => null, 'guardian_relationship' => null,
        ];

        $guardians = $this->child?->family?->guardians;

        if ($guardians) {
            foreach ($guardians as $guardian) {
                $age = $guardian->guardian_birth_date
                    ? Carbon::parse($guardian->guardian_birth_date)->diff(now())->format('%y Tahun %m Bulan')
                    : null;

                switch (strtolower($guardian->guardian_type)) {
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
                }
            }
        }

        return array_merge($response, [
            'child_order' => $this->psychosocialHistory?->child_order,
            'siblings' => $this->psychosocialHistory?->siblings,
            'household_members' => $this->psychosocialHistory?->household_members,
            'parent_marriage_status' => $this->psychosocialHistory?->parent_marriage_status,
            'daily_language' => $this->psychosocialHistory?->daily_language,

            'pregnancy_desired' => $this->pregnancyHistory?->pregnancy_desired,
            'routine_checkup' => $this->pregnancyHistory?->routine_checkup,
            'mother_age_at_pregnancy' => $this->pregnancyHistory?->mother_age_at_pregnancy,
            'pregnancy_duration' => $this->pregnancyHistory?->pregnancy_duration,
            'pregnancy_hemoglobin' => $this->pregnancyHistory?->pregnancy_hemoglobin,
            'pregnancy_incidents' => $this->pregnancyHistory?->pregnancy_incidents,
            'medication_consumption' => $this->pregnancyHistory?->medication_consumption,
            'pregnancy_complications' => $this->pregnancyHistory?->pregnancy_complications,

            'birth_type' => $this->birthHistory?->birth_type,
            'if_normal' => $this->birthHistory?->if_normal,
            'caesar_vacuum_reason' => $this->birthHistory?->caesar_vacuum_reason,
            'crying_immediately' => $this->birthHistory?->crying_immediately,
            'birth_condition' => $this->birthHistory?->birth_condition,
            'birth_condition_duration' => $this->birthHistory?->birth_condition_duration,
            'incubator_used' => $this->birthHistory?->incubator_used,
            'incubator_duration' => $this->birthHistory?->incubator_duration,
            'birth_weight' => $this->birthHistory?->birth_weight,
            'birth_length' => $this->birthHistory?->birth_length,
            'head_circumference' => $this->birthHistory?->head_circumference,
            'birth_complications_other' => $this->birthHistory?->birth_complications_other,
            'postpartum_depression' => $this->birthHistory?->postpartum_depression,

            'postbirth_condition' => $this->postBirthHistory?->postbirth_condition,
            'postbirth_condition_duration' => $this->postBirthHistory?->postbirth_condition_duration,
            'postbirth_condition_age' => $this->postBirthHistory?->postbirth_condition_age,
            'has_ever_fallen' => $this->postBirthHistory?->has_ever_fallen,
            'injured_body_part' => $this->postBirthHistory?->injured_body_part,
            'age_at_fall' => $this->postBirthHistory?->age_at_fall,
            'other_postbirth_complications' => $this->postBirthHistory?->other_postbirth_complications,
            'head_lift_age' => $this->postBirthHistory?->head_lift_age,
            'prone_age' => $this->postBirthHistory?->prone_age,
            'roll_over_age' => $this->postBirthHistory?->roll_over_age,
            'sitting_age' => $this->postBirthHistory?->sitting_age,
            'crawling_age' => $this->postBirthHistory?->crawling_age,
            'climbing_age' => $this->postBirthHistory?->climbing_age,
            'standing_age' => $this->postBirthHistory?->standing_age,
            'walking_age' => $this->postBirthHistory?->walking_age,
            'complete_immunization' => $this->postBirthHistory?->complete_immunization,
            'uncompleted_immunization_detail' => $this->postBirthHistory?->uncompleted_immunization_detail,
            'exclusive_breastfeeding' => $this->postBirthHistory?->exclusive_breastfeeding,
            'exclusive_breastfeeding_until_age' => $this->postBirthHistory?->exclusive_breastfeeding_until_age,
            'rice_intake_age' => $this->postBirthHistory?->rice_intake_age,

            'allergies_age' => $this->healthHistory?->allergies_age,
            'fever_age' => $this->healthHistory?->fever_age,
            'ear_infections_age' => $this->healthHistory?->ear_infections_age,
            'headaches_age' => $this->healthHistory?->headaches_age,
            'mastoiditis_age' => $this->healthHistory?->mastoiditis_age,
            'sinusitis_age' => $this->healthHistory?->sinusitis_age,
            'asthma_age' => $this->healthHistory?->asthma_age,
            'seizures_age' => $this->healthHistory?->seizures_age,
            'encephalitis_age' => $this->healthHistory?->encephalitis_age,
            'high_fever_age' => $this->healthHistory?->high_fever_age,
            'meningitis_age' => $this->healthHistory?->meningitis_age,
            'tonsillitis_age' => $this->healthHistory?->tonsillitis_age,
            'chickenpox_age' => $this->healthHistory?->chickenpox_age,
            'dizziness_age' => $this->healthHistory?->dizziness_age,
            'measles_or_rubella_age' => $this->healthHistory?->measles_or_rubella_age,
            'influenza_age' => $this->healthHistory?->influenza_age,
            'pneumonia_age' => $this->healthHistory?->pneumonia_age,
            'others' => $this->healthHistory?->others,
            'family_similar_conditions_detail' => $this->healthHistory?->family_similar_conditions_detail,
            'family_mental_disorders' => $this->healthHistory?->family_mental_disorders,
            'child_surgeries_detail' => $this->healthHistory?->child_surgeries_detail,
            'special_medical_conditions' => $this->healthHistory?->special_medical_conditions,
            'other_medications_detail' => $this->healthHistory?->other_medications_detail,
            'negative_reactions_detail' => $this->healthHistory?->negative_reactions_detail,
            'hospitalization_history' => $this->healthHistory?->hospitalization_history,

            'currently_in_school' => $this->educationHistory?->currently_in_school,
            'school_location' => $this->educationHistory?->school_location,
            'school_class' => $this->educationHistory?->school_class,
            'long_absence_from_school' => $this->educationHistory?->long_absence_from_school,
            'long_absence_reason' => $this->educationHistory?->long_absence_reason,
            'academic_and_socialization_detail' => $this->educationHistory?->academic_and_socialization_detail,
            'special_treatment_detail' => $this->educationHistory?->special_treatment_detail,
            'learning_support_program' => $this->educationHistory?->learning_support_program,
            'learning_support_detail' => $this->educationHistory?->learning_support_detail,
        ]);
    }
}
