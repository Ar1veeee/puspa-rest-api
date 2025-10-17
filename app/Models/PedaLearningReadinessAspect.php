<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedaLearningReadinessAspect extends Model
{
    use HasFactory;

    protected $table = 'peda_learning_readiness_aspects';
    public $timestamps = false;

    protected $fillable = [
        'follow_instructions_score',
        'follow_instructions_desc',
        'sit_calmly_score',
        'sit_calmly_desc',
        'not_hyperactive_score',
        'not_hyperactive_desc',
        'show_initiative_score',
        'show_initiative_desc',
        'is_cooperative_score',
        'is_cooperative_desc',
        'show_enthusiasm_score',
        'show_enthusiasm_desc',
        'complete_tasks_score',
        'complete_tasks_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(PedaAssessmentTherapist::class, 'learning_readiness_aspect_id');
    }
}
