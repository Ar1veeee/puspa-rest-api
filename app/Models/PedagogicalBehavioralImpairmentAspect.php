<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedagogicalBehavioralImpairmentAspect extends Model
{
    use HasFactory;
    protected $table = 'pedagogical_behavioral_impairment_aspects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'has_behavioral_problems',
        'easily_befriends_peers',
        'quick_mood_swings',
        'likes_violence_expressing_emotions',
        'tends_to_be_alone',
        'reluctant_to_greet_smile',
    ];

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'behavioral_impairment_aspect_id');
    }
}
