<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccupationalBehaviorScale extends Model
{
    use HasFactory;

    protected $table = 'occupational_behavior_scales';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'easy_to_surrender',
        'distracted_by_attention',
        'difficulty_sitting_quietly_5min',
        'cannot_concentrate_20min',
        'often_tries_to_forget_personal_belongings',
        'responds_without_clear_reason',
        'refuses_to_follow_orders_even_simple',
        'not_patient_waiting_turn',
    ];

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
