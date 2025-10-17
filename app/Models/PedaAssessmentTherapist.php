<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedaAssessmentTherapist extends Model
{
    use HasFactory;

    protected $table = 'peda_assessment_therapists';

    protected $fillable = [
        'assessment_id',
        'therapist_id',
        'reading_aspect_id',
        'writing_aspect_id',
        'counting_aspect_id',
        'learning_readiness_aspect_id',
        'general_knowledge_aspect_id',
        'summary',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }

    public function readingAspect(): BelongsTo
    {
        return $this->belongsTo(PedaReadingAspect::class, 'reading_aspect_id');
    }

    public function writingAspect(): BelongsTo
    {
        return $this->belongsTo(PedaWritingAspect::class, 'writing_aspect_id');
    }

    public function countingAspect(): BelongsTo
    {
        return $this->belongsTo(PedaCountingAspect::class, 'counting_aspect_id');
    }

    public function learningReadinessAspect(): BelongsTo
    {
        return $this->belongsTo(PedaLearningReadinessAspect::class, 'learning_readiness_aspect_id');
    }

    public function generalKnowledgeAspect(): BelongsTo
    {
        return $this->belongsTo(PedaGeneralKnowledgeAspect::class, 'general_knowledge_aspect_id');
    }
}
