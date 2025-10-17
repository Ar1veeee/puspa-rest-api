<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpeechAssessmentTherapist extends Model
{
    use HasFactory;

    protected $table = 'speech_assessment_therapists';

    protected $fillable = [
        'assessment_id',
        'therapist_id',
        'oral_facial_aspect_id',
        'language_skill_aspect_id',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }

    public function oralFacialAspect(): BelongsTo
    {
        return $this->belongsTo(SpeechOralFacialAspect::class, 'oral_facial_aspect_id');
    }

    public function languageSkillAspect(): BelongsTo
    {
        return $this->belongsTo(SpeechLanguageSkillAspect::class, 'language_skill_aspect_id');
    }
}
