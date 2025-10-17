<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpeechOralFacialAspect extends Model
{
    use HasFactory;

    protected $table = 'speech_oral_facial_aspects';
    public $timestamps = false;

    protected $fillable = [
        'lip_range_of_motion', 'lip_range_of_motion_note', 'lip_symmetry', 'lip_symmetry_note', 'lip_tongue_strength', 'lip_tongue_strength_note', 'lip_other_note',
        'tongue_color', 'tongue_color_note', 'tongue_abnormal_movement', 'tongue_abnormal_movement_note', 'tongue_size', 'tongue_size_note', 'tongue_frenulum', 'tongue_frenulum_note', 'tongue_other_note',
        'tongue_symmetry_prone', 'tongue_symmetry_prone_note', 'tongue_range_of_motion_prone', 'tongue_range_of_motion_prone_note', 'tongue_speed_prone', 'tongue_speed_prone_note', 'tongue_strength_prone', 'tongue_strength_prone_note', 'tongue_other_note_prone',
        'tongue_symmetry_lying', 'tongue_symmetry_lying_note', 'tongue_range_of_motion_lying', 'tongue_range_of_motion_lying_note', 'tongue_speed_lying', 'tongue_speed_lying_note', 'tongue_strength_lying', 'tongue_strength_lying_note', 'tongue_other_note_lying',
        'tongue_strength_spatel_normal', 'tongue_strength_spatel_note', 'tongue_strength_spatel_other',
        'tongue_open_mouth_symmetry', 'tongue_open_mouth_symmetry_note', 'tongue_open_mouth_range_of_motion', 'tongue_open_mouth_range_of_motion_note', 'tongue_open_mouth_speed', 'tongue_open_mouth_speed_note', 'tongue_open_mouth_strength', 'tongue_open_mouth_strength_note', 'tongue_open_mouth_other_note',
        'tongue_protrusion_symmetry', 'tongue_protrusion_symmetry_note', 'tongue_protrusion_range_of_motion', 'tongue_protrusion_range_of_motion_note', 'tongue_protrusion_speed', 'tongue_protrusion_speed_note', 'tongue_protrusion_strength', 'tongue_protrusion_strength_note', 'tongue_protrusion_other_note',
        'dental_occlusion', 'dental_occlusion_note', 'dental_occlusion_taring', 'dental_occlusion_taring_note', 'dental_teeth', 'dental_teeth_note', 'dental_arrangement', 'dental_arrangement_note', 'dental_cleanliness', 'dental_cleanliness_note', 'dental_other_note',
        'face_symmetry', 'face_symmetry_note', 'face_abnormal_movement', 'face_abnormal_movement_note', 'face_muscle_flexation', 'face_muscle_flexation_note', 'face_other_note',
        'jaw_range_of_motion', 'jaw_range_of_motion_note', 'jaw_symmetry', 'jaw_symmetry_note', 'jaw_movement', 'jaw_movement_note', 'jaw_tmj_noises', 'jaw_tmj_noises_note', 'jaw_other_note',
        'palate_color', 'palate_color_note', 'palate_rugae', 'palate_rugae_note', 'palate_hard_height', 'palate_hard_height_note', 'palate_hard_width', 'palate_hard_width_note', 'palate_growths', 'palate_growths_note', 'palate_fistula', 'palate_fistula_note', 'palate_soft_symmetry', 'palate_soft_symmetry_note', 'palate_soft_height', 'palate_soft_height_note', 'palate_other_note',
        'palate_hard_up_range_of_motion', 'palate_hard_up_range_of_motion_note', 'palate_hard_up_speed', 'palate_hard_up_speed_note', 'palate_hard_up_other_note',
        'palate_soft_down_range_of_motion', 'palate_soft_down_range_of_motion_note', 'palate_soft_down_speed', 'palate_soft_down_speed_note', 'palate_soft_down_other_note',
        'palate_up_range_of_motion', 'palate_up_range_of_motion_note', 'palate_up_speed', 'palate_up_speed_note', 'palate_up_other_note',
        'palate_lateral_movement', 'palate_lateral_movement_note', 'palate_lateral_range_of_motion', 'palate_lateral_range_of_motion_note', 'palate_lateral_other_note',
        'pharynx_color', 'pharynx_color_note', 'pharynx_tonus', 'pharynx_tonus_note', 'pharynx_other_note',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(SpeechAssessmentTherapist::class, 'oral_facial_aspect_id');
    }
}
