<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessments';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'observation_id',
        'child_id',
        'admin_id',
        'therapist_id',
        'scheduled_date',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'fisio' => 'boolean',
        'wicara' => 'boolean',
        'paedagog' => 'boolean',
        'okupasi' => 'boolean',
    ];

    public function assessmentDetails(): HasMany
    {
        return $this->hasMany(AssessmentDetail::class, 'assessment_id', 'id');
    }

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'assessment_id', 'id');
    }

    public function physioAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PhysioAssessmentGuardian::class, 'assessment_id', 'id');
    }

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class, 'assessment_id', 'id');
    }

    public function speechAssessmentGuardian(): HasOne
    {
        return $this->hasOne(SpeechAssessmentGuardian::class, 'assessment_id', 'id');
    }

    public function psychosocialHistory(): HasOne
    {
        return $this->hasOne(ChildPsychosocialHistory::class, 'assessment_id', 'id');
    }

    public function pregnancyHistory(): HasOne
    {
        return $this->hasOne(ChildPregnancyHistory::class);
    }

    public function birthHistory(): HasOne
    {
        return $this->hasOne(ChildBirthHistory::class);
    }

    public function postBirthHistory(): HasOne
    {
        return $this->hasOne(ChildPostBirthHistory::class);
    }

    public function healthHistory(): HasOne
    {
        return $this->hasOne(ChildHealthHistory::class);
    }

    public function educationHistory(): HasOne
    {
        return $this->hasOne(ChildEducationHistory::class);
    }

    public function speechAssessmentTherapist(): HasOne
    {
        return $this->hasOne(SpeechAssessmentTherapist::class, 'assessment_id', 'id');
    }

    public function pedaAssessmentTherapist(): HasOne
    {
        return $this->hasOne(PedaAssessmentTherapist::class, 'assessment_id', 'id');
    }

    public function occuAssessmentTherapist(): HasOne
    {
        return $this->hasOne(OccuAssessmentTherapist::class, 'assessment_id', 'id');
    }

    public function physioAssessmentTherapist(): HasOne
    {
        return $this->hasOne(PhysioAssessmentTherapist::class, 'assessment_id', 'id');
    }

    public function observation(): BelongsTo
    {
        return $this->belongsTo(ObservationAnswer::class, 'observation_id', 'id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class, 'child_id', 'id');
    }
}
