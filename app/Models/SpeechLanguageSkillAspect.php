<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpeechLanguageSkillAspect extends Model
{
    use HasFactory;

    protected $table = 'speech_language_skill_aspects';
    public $timestamps = false;

    protected $fillable = [
        'age_category',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(SpeechAssessmentTherapist::class, 'language_skill_aspect_id');
    }
}
