<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccupationalAdlMotorSkill extends Model
{
    use HasFactory;

    protected $table = 'occupational_adl_motor_skills';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'difficulty_regulating_emotions',
        'difficulty_dressing',
        'difficulty_wearing_shoes_socks',
        'difficulty_tying_shoelaces',
        'difficulty_buttoning',
        'difficulty_self_cleaning',
        'difficulty_brushing_teeth',
        'difficulty_combing_hair',
        'difficulty_standing_on_one_leg',
        'difficulty_jumping_in_place',
        'difficulty_skipping_rope',
        'difficulty_riding_bike',
        'difficulty_using_playground_equipment',
        'difficulty_climbing_stairs',
    ];

    protected $casts = [
        'difficulty_regulating_emotions' => 'boolean',
        'difficulty_dressing' => 'boolean',
        'difficulty_wearing_shoes_socks' => 'boolean',
        'difficulty_tying_shoelaces' => 'boolean',
        'difficulty_buttoning' => 'boolean',
        'difficulty_self_cleaning' => 'boolean',
        'difficulty_brushing_teeth' => 'boolean',
        'difficulty_combing_hair' => 'boolean',
        'difficulty_standing_on_one_leg' => 'boolean',
        'difficulty_jumping_in_place' => 'boolean',
        'difficulty_skipping_rope' => 'boolean',
        'difficulty_riding_bike' => 'boolean',
        'difficulty_using_playground_equipment' => 'boolean',
        'difficulty_climbing_stairs' => 'boolean',
    ];

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
