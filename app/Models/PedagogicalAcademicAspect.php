<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedagogicalAcademicAspect extends Model
{
    use HasFactory;

    protected $table = 'pedagogical_academic_aspects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'iq_measurement',
        'iq_score',
        'extra_academic_class',
        'special_teacher',
        'curriculum_modification',
        'seating_position_in_class',
        'child_hobbies',
        'non_academic_activity_detail',
        'non_academic_activity_location',
        'non_academic_activity_time',
        'learning_focus',
        'focus_duration',
        'focus_objects',
        'daily_home_study',
        'home_study_time',
        'home_study_companion',
        'study_environment_condition',
        'favorite_subject',
        'least_favorite_subject',
    ];

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'academic_aspect_id');
    }
}
