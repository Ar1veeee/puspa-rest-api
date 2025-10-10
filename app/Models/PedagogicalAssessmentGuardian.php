<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedagogicalAssessmentGuardian extends Model
{
    use HasFactory;

    protected $table = 'pedagogical_assessment_guardians';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'academic_aspect_id',
        'visual_impairment_aspect_id',
        'auditory_impairment_aspect_id',
        'cognitive_impairment_aspect_id',
        'motor_impairment_aspects_id',
        'behavioral_impairment_aspect_id',
        'social_communication_aspect_id',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function academicAspect(): BelongsTo
    {
        return $this->belongsTo(PedagogicalAcademicAspect::class, 'academic_aspect_id');
    }

    public function visualImpairmentAspect(): BelongsTo
    {
        return $this->belongsTo(PedagogicalVisualImpairmentAspect::class, 'visual_impairment_aspect_id');
    }

    public function auditoryImpairmentAspect(): BelongsTo
    {
        return $this->belongsTo(PedagogicalAuditoryImpairmentAspect::class, 'auditory_impairment_aspect_id');
    }

    public function cognitiveImpairmentAspect(): BelongsTo
    {
        return $this->belongsTo(PedagogicalCognitiveImpairmentAspect::class, 'cognitive_impairment_aspect_id');
    }

    public function motorImpairmentAspect(): BelongsTo
    {
        return $this->belongsTo(PedagogicalMotorImpairmentAspect::class, 'motor_impairment_aspects_id');
    }

    public function behavioralImpairmentAspect(): BelongsTo
    {
        return $this->belongsTo(PedagogicalBehavioralImpairmentAspect::class, 'behavioral_impairment_aspect_id');
    }

    public function socialCommunicationAspect(): BelongsTo
    {
        return $this->belongsTo(PedagogicalSocialCommunicationAspect::class, 'social_communication_aspect_id');
    }
}
