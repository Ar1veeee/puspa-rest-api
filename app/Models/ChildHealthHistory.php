<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildHealthHistory extends Model
{
    use HasFactory;

    protected $table = 'child_health_histories';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'allergies_age',
        'fever_age',
        'ear_infections_age',
        'headaches_age',
        'mastoiditis_age',
        'sinusitis_age',
        'asthma_age',
        'seizures_age',
        'encephalitis_age',
        'high_fever_age',
        'meningitis_age',
        'tonsillitis_age',
        'chickenpox_age',
        'dizziness_age',
        'measles_or_rubella_age',
        'influenza_age',
        'other_disease',
        'family_similar_conditions_detail',
        'family_mental_disorders',
        'child_surgeries_detail',
        'special_medical_conditions',
        'other_medications_detail',
        'negative_reactions_detail',
        'hospitalization_history',
    ];

    protected $casts = [
        'other_disease' => 'array',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }
}
