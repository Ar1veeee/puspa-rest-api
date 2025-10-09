<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedagogicalCognitiveImpairmentAspect extends Model
{
    use HasFactory;

    protected $table = 'pedagogical_cognitive_impairment_aspects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'has_cognitive_impairment',
        'needs_explanation_managing_information',
        'responsive_to_sudden_events',
        'preferred_activities',
        'interested_in_learning_new_info',
    ];

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'cognitive_impairment_aspect_id');
    }
}
