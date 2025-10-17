<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysioAssessmentTherapist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'assessment_id',
        'therapist_id',
        'general_examination_id',
        'system_anamnesis_id',
        'sensory_examination_id',
        'reflex_examination_id',
        'muscle_strength_examination_id',
        'spasticity_examination_id',
        'joint_laxity_test_id',
        'gross_motor_examination_id',
        'muscle_palpation_id',
        'spasticity_type_id',
        'play_function_test_id',
        'physiotherapy_diagnosis_id',
    ];

    /**
     * Get the assessment that owns the physio assessment.
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Get the therapist that owns the physio assessment.
     */
    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }

    /**
     * Get the general examination details.
     */
    public function generalExamination(): BelongsTo
    {
        return $this->belongsTo(PhysioGeneralExamination::class, 'general_examination_id');
    }

    /**
     * Get the system anamnesis details.
     */
    public function systemAnamnesis(): BelongsTo
    {
        return $this->belongsTo(PhysioSystemAnamnesis::class, 'system_anamnesis_id');
    }

    /**
     * Get the sensory examination details.
     */
    public function sensoryExamination(): BelongsTo
    {
        return $this->belongsTo(PhysioSensoryExamination::class, 'sensory_examination_id');
    }

    /**
     * Get the reflex examination details.
     */
    public function reflexExamination(): BelongsTo
    {
        return $this->belongsTo(PhysioReflexExamination::class, 'reflex_examination_id');
    }

    /**
     * Get the muscle strength examination details.
     */
    public function muscleStrengthExamination(): BelongsTo
    {
        return $this->belongsTo(PhysioMuscleStrengthExamination::class, 'muscle_strength_examination_id');
    }

    /**
     * Get the spasticity examination details.
     */
    public function spasticityExamination(): BelongsTo
    {
        return $this->belongsTo(PhysioSpasticityExamination::class, 'spasticity_examination_id');
    }

    /**
     * Get the joint laxity test details.
     */
    public function jointLaxityTest(): BelongsTo
    {
        return $this->belongsTo(PhysioJointLaxityTest::class, 'joint_laxity_test_id');
    }

    /**
     * Get the gross motor examination details.
     */
    public function grossMotorExamination(): BelongsTo
    {
        return $this->belongsTo(PhysioGrossMotorExamination::class, 'gross_motor_examination_id');
    }

    /**
     * Get the muscle palpation details.
     */
    public function musclePalpation(): BelongsTo
    {
        return $this->belongsTo(PhysioMusclePalpation::class, 'muscle_palpation_id');
    }

    /**
     * Get the spasticity type details.
     */
    public function spasticityType(): BelongsTo
    {
        return $this->belongsTo(PhysioSpasticityType::class, 'spasticity_type_id');
    }

    /**
     * Get the play function test details.
     */
    public function playFunctionTest(): BelongsTo
    {
        return $this->belongsTo(PhysioPlayFunctionTest::class, 'play_function_test_id');
    }

    /**
     * Get the physiotherapy diagnosis details.
     */
    public function physiotherapyDiagnosis(): BelongsTo
    {
        return $this->belongsTo(PhysioPhysiotherapyDiagnosis::class, 'physiotherapy_diagnosis_id');
    }
}
