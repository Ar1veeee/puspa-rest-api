<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhysioTherapistDataAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'assessment_id' => $this->assessment_id,
            'therapist' => new TherapistResource($this->whenLoaded('therapist')),
            'physio_assessment_id' => $this->id,
            'general_examination' => new PhysioGeneralExaminationResource($this->whenLoaded('generalExamination')),
            'system_anamnesis' => new PhysioSystemAnamnesisResource($this->whenLoaded('systemAnamnesis')),
            'sensory_examination' => new PhysioSensoryExaminationResource($this->whenLoaded('sensoryExamination')),
            'reflex_examination' => new PhysioReflexExaminationResource($this->whenLoaded('reflexExamination')),
            'muscle_strength_examination' => new PhysioMuscleStrengthExaminationResource($this->whenLoaded('muscleStrengthExamination')),
            'spasticity_examination' => new PhysioSpasticityExaminationResource($this->whenLoaded('spasticityExamination')),
            'joint_laxity_test' => new PhysioJointLaxityTestResource($this->whenLoaded('jointLaxityTest')),
            'gross_motor_examination' => new PhysioGrossMotorExaminationResource($this->whenLoaded('grossMotorExamination')),
            'muscle_palpation' => new PhysioMusclePalpationResource($this->whenLoaded('musclePalpation')),
            'spasticity_type' => new PhysioSpasticityTypeResource($this->whenLoaded('spasticityType')),
            'play_function_test' => new PhysioPlayFunctionTestResource($this->whenLoaded('playFunctionTest')),
            'physiotherapy_diagnosis' => new PhysioPhysiotherapyDiagnosisResource($this->whenLoaded('physiotherapyDiagnosis')),
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];
    }
}

/**
 * =================================================================
 * Resource Anak (Pemeriksaan)
 * =================================================================
 * Ini adalah semua resource pendukung yang dimuat oleh resource utama.
 */

// Resource untuk Therapist
class TherapistResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'therapist_name' => $this->therapist_name,
        ];
    }
}

// Resource untuk physio_general_examinations
class PhysioGeneralExaminationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'arrival_method' => $this->arrival_method,
            'consciousness' => $this->consciousness,
            'cooperation' => $this->cooperation,
            'blood_pressure' => $this->blood_pressure,
            'pulse' => $this->pulse,
            'respiratory_rate' => $this->respiratory_rate,
            'nutritional_status' => $this->nutritional_status,
            'temperature' => $this->temperature,
            'head_circumference' => (float) $this->head_circumference,
        ];
    }
}

// Resource untuk physio_system_anamnesis
class PhysioSystemAnamnesisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'head_and_neck' => $this->head_and_neck,
            'cardiovascular' => $this->cardiovascular,
            'respiratory' => $this->respiratory,
            'gastrointestinal' => $this->gastrointestinal,
            'urogenital' => $this->urogenital,
            'musculoskeletal' => $this->musculoskeletal,
            'nervous_system' => $this->nervous_system,
            'sensory' => $this->sensory,
            'motoric' => $this->motoric,
        ];
    }
}

// Resource untuk physio_sensory_examinations
class PhysioSensoryExaminationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'visual' => $this->visual,
            'auditory' => $this->auditory,
            'olfactory' => $this->olfactory,
            'gustatory' => $this->gustatory,
            'tactile' => $this->tactile,
            'proprioceptive' => $this->proprioceptive,
            'vestibular' => $this->vestibular,
        ];
    }
}

// Resource untuk physio_reflex_examinations (Dikelompokkan agar rapi)
class PhysioReflexExaminationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Dikelompokkan berdasarkan jenis reflek agar JSON lebih mudah dibaca
        return [
            'id' => $this->id,
            'moro' => $this->getReflexData('moro'),
            'blinking' => $this->getReflexData('blinking'),
            'galant' => $this->getReflexData('galant'),
            'atnr' => $this->getReflexData('atnr'),
            'stnr' => $this->getReflexData('stnr'),
            'sucking' => $this->getReflexData('sucking'),
            'rooting' => $this->getReflexData('rooting'),
            'palmar_grasps' => $this->getReflexData('palmar_grasps'),
            'plantar_grasps' => $this->getReflexData('plantar_grasps'),
            'flexor_withdrawal' => $this->getReflexData('flexor_withdrawal'),
            'babinsky' => $this->getReflexData('babinsky'),
            'righting' => $this->getReflexData('righting'),
            'automatic_gait_reflex' => $this->getReflexData('automatic_gait_reflex'),
            'parachute' => $this->getReflexData('parachute'),
            'landau' => $this->getReflexData('landau'),
            'protective_reflex' => $this->getReflexData('protective_reflex'),
        ];
    }

    // Helper function untuk mengambil data reflek
    private function getReflexData(string $prefix): array
    {
        return [
            'result' => $this->{$prefix . '_result'},
            'primitive' => $this->{$prefix . '_primitive'},
            'functional' => $this->{$prefix . '_functional'},
            'pathological' => $this->{$prefix . '_pathological'},
            'integration' => $this->{$prefix . '_integration'},
            'not_synchronous' => $this->{$prefix . '_not_synchronous'},
        ];
    }
}

// Resource untuk physio_gross_motor_examinations (Dikelompokkan agar rapi)
class PhysioGrossMotorExaminationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'supine' => [
                'head' => $this->supine_head,
                'shoulder' => $this->supine_shoulder,
                'elbow' => $this->supine_elbow,
                'wrist' => $this->supine_wrist,
                'finger' => $this->supine_finger,
                'trunk' => $this->supine_trunk,
                'hip' => $this->supine_hip,
                'knee' => $this->supine_knee,
                'ankle' => $this->supine_ankle,
            ],
            'rolling' => [
                'handling' => $this->rolling_handling,
                'rolling_via' => $this->rolling_rolling_via,
                'trunk_rotation' => $this->rolling_trunk_rotation,
            ],
            'prone' => [
                'head_lifting' => $this->prone_head_lifting,
                'head_control' => $this->prone_head_control,
                'forearm_support' => $this->prone_forearm_support,
                'hand_support' => $this->prone_hand_support,
                'hip' => $this->prone_hip,
                'knee' => $this->prone_knee,
                'ankle' => $this->prone_ankle,
            ],
            'sitting' => [
                'head_lifting' => $this->sitting_head_lifting,
                'head_control' => $this->sitting_head_control,
                'head_support' => $this->sitting_head_support,
                'trunk_control' => $this->sitting_trunk_control,
                'balance' => $this->sitting_balance,
                'protective_reaction' => $this->sitting_protective_reaction,
                'position' => $this->sitting_position,
                'weight_bearing' => $this->sitting_weight_bearing,
            ],
            'standing' => [
                'head_lifting' => $this->standing_head_lifting,
                'head_control' => $this->standing_head_control,
                'trunk_control' => $this->standing_trunk_control,
                'hip' => $this->standing_hip,
                'knee' => $this->standing_knee,
                'ankle' => $this->standing_ankle,
                'support' => $this->standing_support,
                'posture' => $this->standing_posture,
            ],
            'walking' => [
                'bad_posture' => $this->walking_bad_posture,
                'gait_pattern' => $this->walking_gait_pattern,
                'balance' => $this->walking_balance,
                'knee_type' => $this->walking_knee_type,
            ],
        ];
    }
}

// Resource untuk physio_joint_laxity_tests
class PhysioJointLaxityTestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'elbow' => $this->elbow,
            'wrist' => $this->wrist,
            'hip' => $this->hip,
            'knee' => $this->knee,
            'ankle' => $this->ankle,
        ];
    }
}

// Resource untuk physio_spasticity_examinations
class PhysioSpasticityExaminationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'spas_head_neck_score' => $this->spas_head_neck_score,
            'spas_trunk_score' => $this->spas_trunk_score,
            'spas_aga_dex_score' => $this->spas_aga_dex_score,
            'spas_aga_sin_score' => $this->spas_aga_sin_score,
            'spas_agb_dex_score' => $this->spas_agb_dex_score,
            'spas_agb_sin_score' => $this->spas_agb_sin_score,
        ];
    }
}

// Resource untuk physio_muscle_strength_examinations
class PhysioMuscleStrengthExaminationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'str_trunk_score' => $this->str_trunk_score,
            'str_aga_dex_score' => $this->str_aga_dex_score,
            'str_aga_sin_score' => $this->str_aga_sin_score,
            'str_agb_dex_score' => $this->str_agb_dex_score,
            'str_agb_sin_score' => $this->str_agb_sin_score,
        ];
    }
}

// Resource untuk physio_muscle_palpations (Dikelompokkan agar rapi)
class PhysioMusclePalpationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hypertonus' => [
                'aga_d' => $this->hypertonus_aga_d,
                'aga_s' => $this->hypertonus_aga_s,
                'agb_d' => $this->hypertonus_agb_d,
                'agb_s' => $this->hypertonus_agb_s,
                'perut' => $this->hypertonus_perut,
            ],
            'hypotonus' => [
                'aga_d' => $this->hypotonus_aga_d,
                'aga_s' => $this->hypotonus_aga_s,
                'agb_d' => $this->hypotonus_agb_d,
                'agb_s' => $this->hypotonus_agb_s,
                'perut' => $this->hypotonus_perut,
            ],
            'flyktuatif' => [
                'aga_d' => $this->flyktuatif_aga_d,
                'aga_s' => $this->flyktuatif_aga_s,
                'agb_d' => $this->flyktuatif_agb_d,
                'agb_s' => $this->flyktuatif_agb_s,
                'perut' => $this->flyktuatif_perut,
            ],
            'normal' => [
                'aga_d' => $this->normal_aga_d,
                'aga_s' => $this->normal_aga_s,
                'agb_d' => $this->normal_agb_d,
                'agb_s' => $this->normal_agb_s,
                'perut' => $this->normal_perut,
            ],
        ];
    }
}

// Resource untuk physio_spasticity_types
class PhysioSpasticityTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hemiplegia' => $this->hemiplegia,
            'diplegia' => $this->diplegia,
            'quadriplegia' => $this->quadriplegia,
            'monoplegia' => $this->monoplegia,
            'triplegia' => $this->triplegia,
        ];
    }
}

// Resource untuk physio_play_function_tests
class PhysioPlayFunctionTestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'play_type' => $this->play_type,
            'follow_object' => $this->follow_object,
            'follow_sound' => $this->follow_sound,
            'reach_object' => $this->reach_object,
            'grasping' => $this->grasping,
            'differentiate_color' => $this->differentiate_color,
            'focus_attention' => $this->focus_attention,
        ];
    }
}

// Resource untuk physio_physiotherapy_diagnoses
class PhysioPhysiotherapyDiagnosisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'impairments' => $this->impairments,
            'functional_limitations' => $this->functional_limitations,
            'participant_restrictions' => $this->participant_restrictions,
        ];
    }
}
