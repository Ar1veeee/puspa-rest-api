<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccupationalBehaviorSocial extends Model
{
    use HasFactory;

    protected $table = 'occupational_behavior_socials';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'is_quiet',
        'is_hyperactive',
        'difficulty_managing_frustration',
        'is_impulsive',
        'attention_seeking',
        'withdrawn',
        'is_curious',
        'is_aggressive',
        'is_shy',
        'behavior_problems_at_home',
        'behavior_problems_at_school',
        'is_emotional',
        'unusual_fears',
        'frequent_tantrums',
        'good_relationship_with_siblings',
        'makes_friends_easily',
        'understands_game_rules',
        'understands_jokes',
        'is_rigid',
        'plays_with_other_children',
    ];

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
