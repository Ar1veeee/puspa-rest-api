<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioGrossMotorExamination extends Model
{
    use HasFactory;

    protected $table = 'physio_gross_motor_examinations';

    public $timestamps = false;

    protected $fillable = [
        'supine_head',
        'supine_shoulder',
        'supine_elbow',
        'supine_wrist',
        'supine_finger',
        'supine_trunk',
        'supine_hip',
        'supine_knee',
        'supine_ankle',
        'rolling_handling',
        'rolling_rolling_via',
        'rolling_trunk_rotation',
        'prone_head_lifting',
        'prone_head_control',
        'prone_forearm_support',
        'prone_hand_support',
        'prone_hip',
        'prone_knee',
        'prone_ankle',
        'sitting_head_lifting',
        'sitting_head_control',
        'sitting_head_support',
        'sitting_trunk_control',
        'sitting_balance',
        'sitting_protective_reaction',
        'sitting_position',
        'sitting_weight_bearing',
        'standing_head_lifting',
        'standing_head_control',
        'standing_trunk_control',
        'standing_hip',
        'standing_knee',
        'standing_ankle',
        'standing_support',
        'standing_posture',
        'walking_bad_posture',
        'walking_gait_pattern',
        'walking_balance',
        'walking_knee_type',
    ];
}
