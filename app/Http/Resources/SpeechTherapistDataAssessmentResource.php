<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource Utama: SpeechAssessmentTherapistResource
 * (Tabel: speech_assessment_therapists)
 */
class SpeechTherapistDataAssessmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'assessment_id' => $this->assessment_id,
            'therapist' => new TherapistResource($this->whenLoaded('therapist')),
            'oral_facial_aspect' => new SpeechOralFacialAspectResource($this->whenLoaded('oralFacialAspect')),
            'language_skill_aspect' => new SpeechLanguageSkillAspectResource($this->whenLoaded('languageSkillAspect')),
            'created_at' => $this->created_at->format('d F Y H:i:s'),
            'updated_at' => $this->updated_at->format('d F Y H:i:s'),
        ];
    }
}

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

/**
 * Resource Anak: SpeechOralFacialAspectResource
 * (Tabel: speech_oral_facial_aspects)
 */
class SpeechOralFacialAspectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lip_evaluation' => [
                'range_of_motion' => $this->lip_range_of_motion,
                'range_of_motion_note' => $this->lip_range_of_motion_note,
                'symmetry' => $this->lip_symmetry,
                'symmetry_note' => $this->lip_symmetry_note,
                'tongue_strength' => $this->lip_tongue_strength,
                'tongue_strength_note' => $this->lip_tongue_strength_note,
                'other_note' => $this->lip_other_note,
            ],
            'tongue_evaluation_general' => [
                'color' => $this->tongue_color,
                'color_note' => $this->tongue_color_note,
                'abnormal_movement' => $this->tongue_abnormal_movement,
                'abnormal_movement_note' => $this->tongue_abnormal_movement_note,
                'size' => $this->tongue_size,
                'size_note' => $this->tongue_size_note,
                'frenulum' => $this->tongue_frenulum,
                'frenulum_note' => $this->tongue_frenulum_note,
                'other_note' => $this->tongue_other_note,
            ],
            'tongue_evaluation_prone' => [
                'symmetry' => $this->tongue_symmetry_prone,
                'symmetry_note' => $this->tongue_symmetry_prone_note,
                'range_of_motion' => $this->tongue_range_of_motion_prone,
                'range_of_motion_note' => $this->tongue_range_of_motion_prone_note,
                'speed' => $this->tongue_speed_prone,
                'speed_note' => $this->tongue_speed_prone_note,
                'strength' => $this->tongue_strength_prone,
                'strength_note' => $this->tongue_strength_prone_note,
                'other_note' => $this->tongue_other_note_prone,
            ],
            'tongue_evaluation_lying' => [
                'symmetry' => $this->tongue_symmetry_lying,
                'symmetry_note' => $this->tongue_symmetry_lying_note,
                'range_of_motion' => $this->tongue_range_of_motion_lying,
                'range_of_motion_note' => $this->tongue_range_of_motion_lying_note,
                'speed' => $this->tongue_speed_lying,
                'speed_note' => $this->tongue_speed_lying_note,
                'strength' => $this->tongue_strength_lying,
                'strength_note' => $this->tongue_strength_lying_note,
                'other_note' => $this->tongue_other_note_lying,
            ],
            'tongue_evaluation_spatel' => [
                'strength_spatel_normal' => $this->tongue_strength_spatel_normal,
                'strength_spatel_note' => $this->tongue_strength_spatel_note,
                'strength_spatel_other' => $this->tongue_strength_spatel_other,
            ],
            'tongue_evaluation_open_mouth' => [
                'symmetry' => $this->tongue_open_mouth_symmetry,
                'symmetry_note' => $this->tongue_open_mouth_symmetry_note,
                'range_of_motion' => $this->tongue_open_mouth_range_of_motion,
                'range_of_motion_note' => $this->tongue_open_mouth_range_of_motion_note,
                'speed' => $this->tongue_open_mouth_speed,
                'speed_note' => $this->tongue_open_mouth_speed_note,
                'strength' => $this->tongue_open_mouth_strength,
                'strength_note' => $this->tongue_open_mouth_strength_note,
                'other_note' => $this->tongue_open_mouth_other_note,
            ],
            'tongue_evaluation_protrusion' => [
                'symmetry' => $this->tongue_protrusion_symmetry,
                'symmetry_note' => $this->tongue_protrusion_symmetry_note,
                'range_of_motion' => $this->tongue_protrusion_range_of_motion,
                'range_of_motion_note' => $this->tongue_protrusion_range_of_motion_note,
                'speed' => $this->tongue_protrusion_speed,
                'speed_note' => $this->tongue_protrusion_speed_note,
                'strength' => $this->tongue_protrusion_strength,
                'strength_note' => $this->tongue_protrusion_strength_note,
                'other_note' => $this->tongue_protrusion_other_note,
            ],
            'dental_evaluation' => [
                'occlusion' => $this->dental_occlusion,
                'occlusion_note' => $this->dental_occlusion_note,
                'occlusion_taring' => $this->dental_occlusion_taring,
                'occlusion_taring_note' => $this->dental_occlusion_taring_note,
                'teeth' => $this->dental_teeth,
                'teeth_note' => $this->dental_teeth_note,
                'arrangement' => $this->dental_arrangement,
                'arrangement_note' => $this->dental_arrangement_note,
                'cleanliness' => $this->dental_cleanliness,
                'cleanliness_note' => $this->dental_cleanliness_note,
                'other_note' => $this->dental_other_note,
            ],
            'face_evaluation' => [
                'symmetry' => $this->face_symmetry,
                'symmetry_note' => $this->face_symmetry_note,
                'abnormal_movement' => $this->face_abnormal_movement,
                'abnormal_movement_note' => $this->face_abnormal_movement_note,
                'muscle_flexation' => $this->face_muscle_flexation,
                'muscle_flexation_note' => $this->face_muscle_flexation_note,
                'other_note' => $this->face_other_note,
            ],
            'jaw_evaluation' => [
                'range_of_motion' => $this->jaw_range_of_motion,
                'range_of_motion_note' => $this->jaw_range_of_motion_note,
                'symmetry' => $this->jaw_symmetry,
                'symmetry_note' => $this->jaw_symmetry_note,
                'movement' => $this->jaw_movement,
                'movement_note' => $this->jaw_movement_note,
                'tmj_noises' => $this->jaw_tmj_noises,
                'tmj_noises_note' => $this->jaw_tmj_noises_note,
                'other_note' => $this->jaw_other_note,
            ],
            'palate_evaluation' => [
                'color' => $this->palate_color,
                'color_note' => $this->palate_color_note,
                'rugae' => $this->palate_rugae,
                'rugae_note' => $this->palate_rugae_note,
                'hard_height' => $this->palate_hard_height,
                'hard_height_note' => $this->palate_hard_height_note,
                'hard_width' => $this->palate_hard_width,
                'hard_width_note' => $this->palate_hard_width_note,
                'growths' => $this->palate_growths,
                'growths_note' => $this->palate_growths_note,
                'fistula' => $this->palate_fistula,
                'fistula_note' => $this->palate_fistula_note,
                'soft_symmetry' => $this->palate_soft_symmetry,
                'soft_symmetry_note' => $this->palate_soft_symmetry_note,
                'soft_height' => $this->palate_soft_height,
                'soft_height_note' => $this->palate_soft_height_note,
                'other_note' => $this->palate_other_note,
            ],
            'palate_hard_up_evaluation' => [
                'range_of_motion' => $this->palate_hard_up_range_of_motion,
                'range_of_motion_note' => $this->palate_hard_up_range_of_motion_note,
                'speed' => $this->palate_hard_up_speed,
                'speed_note' => $this->palate_hard_up_speed_note,
                'other_note' => $this->palate_hard_up_other_note,
            ],
            'palate_soft_down_evaluation' => [
                'range_of_motion' => $this->palate_soft_down_range_of_motion,
                'range_of_motion_note' => $this->palate_soft_down_range_of_motion_note,
                'speed' => $this->palate_soft_down_speed,
                'speed_note' => $this->palate_soft_down_speed_note,
                'other_note' => $this->palate_soft_down_other_note,
            ],
            'palate_up_evaluation' => [
                'range_of_motion' => $this->palate_up_range_of_motion,
                'range_of_motion_note' => $this->palate_up_range_of_motion_note,
                'speed' => $this->palate_up_speed,
                'speed_note' => $this->palate_up_speed_note,
                'other_note' => $this->palate_up_other_note,
            ],
            'palate_lateral_evaluation' => [
                'movement' => $this->palate_lateral_movement,
                'movement_note' => $this->palate_lateral_movement_note,
                'range_of_motion' => $this->palate_lateral_range_of_motion,
                'range_of_motion_note' => $this->palate_lateral_range_of_motion_note,
                'other_note' => $this->palate_lateral_other_note,
            ],
            'pharynx_evaluation' => [
                'color' => $this->pharynx_color,
                'color_note' => $this->pharynx_color_note,
                'tonus' => $this->pharynx_tonus,
                'tonus_note' => $this->pharynx_tonus_note,
                'other_note' => $this->pharynx_other_note,
            ],
        ];
    }
}


/**
 * Resource Anak: SpeechLanguageSkillAspectResource
 * (Tabel: speech_language_skill_aspects)
 */
class SpeechLanguageSkillAspectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'age_category' => $this->age_category,
            'answers' => $this->answers,
        ];
    }
}
