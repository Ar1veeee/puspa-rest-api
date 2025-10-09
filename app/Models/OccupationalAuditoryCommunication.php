<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccupationalAuditoryCommunication extends Model
{
    use HasFactory;

    protected $table = 'occupational_auditory_communications';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'easily_disturbed_by_sound',
        'cannot_follow_simple_instructions',
        'confused_by_words',
        'only_uses_body_language',
        'likes_to_sing',
        'speech_sound_difficulty',
        'attentive_but_confused',
        'hesitant_to_speak',
        'understands_body_language_facial_expressions',
    ];

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
