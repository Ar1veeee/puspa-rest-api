<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedagogicalAuditoryImpairmentAspect extends Model
{
    use HasFactory;

    protected $table = 'pedagogical_auditory_impairment_aspects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'has_auditory_impairment',
        'using_hearing_aid',
        'immediate_response_when_called',
        'prefers_listening_music_or_singing',
        'prefers_quiet_environment_when_studying',
        'responding_to_dislike_by_covering_ears',
        'often_uses_headset',
    ];

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'auditory_impairment_aspect_id');
    }
}
