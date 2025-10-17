<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OccuAssessmentTherapist extends Model
{
    use HasFactory;

    protected $table = 'occu_assessment_therapists';

    protected $fillable = [
        'assessment_id',
        'therapist_id',
        'bodily_self_sense_id',
        'balance_coordination_id',
        'concentration_problem_solving_id',
        'concept_knowledge_id',
        'motoric_planning_id',
        'note',
        'assessment_result',
        'therapy_recommendation',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }

    public function bodilySelfSense(): BelongsTo
    {
        return $this->belongsTo(OccuBodilySelfSense::class, 'bodily_self_sense_id');
    }

    public function balanceCoordination(): BelongsTo
    {
        return $this->belongsTo(OccuBalanceCoordination::class, 'balance_coordination_id');
    }

    public function concentrationProblemSolving(): BelongsTo
    {
        return $this->belongsTo(OccuConcentrationProblemSolving::class, 'concentration_problem_solving_id');
    }

    public function conceptKnowledge(): BelongsTo
    {
        return $this->belongsTo(OccuConceptKnowledge::class, 'concept_knowledge_id');
    }

    public function motoricPlanning(): BelongsTo
    {
        return $this->belongsTo(OccuMotoricPlanning::class, 'motoric_planning_id');
    }
}
