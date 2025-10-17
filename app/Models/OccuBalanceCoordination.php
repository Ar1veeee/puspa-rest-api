<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccuBalanceCoordination extends Model
{
    use HasFactory;

    protected $table = 'occu_balance_coordinations';
    public $timestamps = false;

    protected $fillable = [
        'left_right_discrimination_score',
        'left_right_discrimination_desc',
        'spatial_position_up_down_score',
        'spatial_position_up_down_desc',
        'spatial_position_out_in_score',
        'spatial_position_out_in_desc',
        'spatial_position_front_back_score',
        'spatial_position_front_back_desc',
        'spatial_position_middle_edge_score',
        'spatial_position_middle_edge_desc',
        'gross_motor_walk_forward_score',
        'gross_motor_walk_forward_desc',
        'gross_motor_walk_backward_score',
        'gross_motor_walk_backward_desc',
        'gross_motor_walk_sideways_score',
        'gross_motor_walk_sideways_desc',
        'gross_motor_tiptoe_score',
        'gross_motor_tiptoe_desc',
        'gross_motor_running_score',
        'gross_motor_running_desc',
        'gross_motor_stand_one_foot_score',
        'gross_motor_stand_one_foot_desc',
        'gross_motor_jump_one_foot_score',
        'gross_motor_jump_one_foot_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(OccuAssessmentTherapist::class, 'balance_coordination_id');
    }
}
