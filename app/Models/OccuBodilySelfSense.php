<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccuBodilySelfSense extends Model
{
    use HasFactory;

    protected $table = 'occu_bodily_self_senses';
    public $timestamps = false;

    protected $fillable = [
        'temperament_alertness_score',
        'temperament_alertness_desc',
        'temperament_cooperative_score',
        'temperament_cooperative_desc',
        'temperament_shyness_score',
        'temperament_shyness_desc',
        'temperament_easily_offended_score',
        'temperament_easily_offended_desc',
        'temperament_happiness_score',
        'temperament_happiness_desc',
        'temperament_physically_fit_score',
        'temperament_physically_fit_desc',
        'behavior_active_score',
        'behavior_active_desc',
        'behavior_aggressive_score',
        'behavior_aggressive_desc',
        'behavior_tantrum_score',
        'behavior_tantrum_desc',
        'behavior_self_aware_score',
        'behavior_self_aware_desc',
        'behavior_impulsive_score',
        'behavior_impulsive_desc',
        'identity_nickname_score',
        'identity_nickname_desc',
        'identity_full_name_score',
        'identity_full_name_desc',
        'identity_age_score',
        'identity_age_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(OccuAssessmentTherapist::class, 'bodily_self_sense_id');
    }
}
