<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpeechAssessmentGuardian extends Model
{
    use HasFactory;

    protected $table = 'speech_assessment_guardians';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'speech_problem_description',
        'communication_method',
        'language_first_known_and_who',
        'main_cause',
        'child_awareness',
        'child_awareness_detail',
        'previous_speech_therapy',
        'previous_speech_therapy_detail',
        'other_specialist',
        'other_specialist_detail',
        'family_communication_disorders',
        'family_communication_disorders_detail',
        'age_child_can_express_one_word',
        'age_child_can_express_two_words',
        'age_child_can_express_three_plus_words',
        'age_child_can_express_sentences',
        'age_child_can_tell_stories',
        'feeding_difficulty',
        'sound_response_description',
    ];

    protected $casts = [
        'child_awareness' => 'boolean',
        'previous_therapy' => 'boolean',
        'previous_therapy_detail' => 'array',
        'other_specialist' => 'boolean',
        'other_specialist_detail' => 'array',
        'family_communication_disorders' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
