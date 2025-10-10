<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OccupationalAssessmentGuardian extends Model
{
    use HasFactory;

    protected $table = 'occupational_assessment_guardians';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'auditory_communication_id',
        'sensory_modality_id',
        'sensory_processing_screening_id',
        'adl_motor_skill_id',
        'behavior_social_id',
        'behavior_scale_id',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function auditoryCommunication(): BelongsTo
    {
        return $this->belongsTo(OccupationalAuditoryCommunication::class);
    }

    public function sensoryModalityTest(): BelongsTo
    {
        return $this->belongsTo(OccupationalSensoryModalityTest::class);
    }

    public function sensoryProcessingScreening(): BelongsTo
    {
        return $this->belongsTo(OccupationalSensoryProcessingScreening::class);
    }

    public function adlMotorSkill(): BelongsTo
    {
        return $this->belongsTo(OccupationalAdlMotorSkill::class);
    }

    public function behaviorSocial(): BelongsTo
    {
        return $this->belongsTo(OccupationalBehaviorSocial::class);
    }

    public function behaviorScale(): BelongsTo
    {
        return $this->belongsTo(OccupationalBehaviorScale::class);
    }
}
