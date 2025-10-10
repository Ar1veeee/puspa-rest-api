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

    protected $casts = [
        'is_quiet' => 'boolean',
        'is_hyperactive' => 'boolean',
        'difficulty_managing_frustration' => 'boolean',
        'is_impulsive' => 'boolean',
        'attention_seeking' => 'boolean',
        'withdrawn' => 'boolean',
        'is_curious' => 'boolean',
        'is_aggressive' => 'boolean',
        'is_shy' => 'boolean',
        'behavior_problems_at_home' => 'boolean',
        'behavior_problems_at_school' => 'boolean',
        'is_emotional' => 'boolean',
        'unusual_fears' => 'boolean',
        'frequent_tantrums' => 'boolean',
        'good_relationship_with_siblings' => 'boolean',
        'makes_friends_easily' => 'boolean',
        'understands_game_rules' => 'boolean',
        'understands_jokes' => 'boolean',
        'is_rigid' => 'boolean',
    ];

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
