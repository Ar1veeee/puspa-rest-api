<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccupationalSensoryProcessingScreening extends Model
{
    use HasFactory;

    protected $table = 'occupational_sensory_processing_screenings';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'disturbed_by_physical_contact_with_others',
        'dislikes_nail_trimming',
        'fear_in_balance_climbing_games',
        'excessive_spinning_swinging_games',
        'passive_when_at_home',
        'likes_to_be_hugged_and_bought',
        'puts_fingers_toys_in_mouth',
        'dislikes_certain_food_textures',
        'disturbed_by_loud_voices',
        'likes_to_touch_objects',
        'disturbed_by_certain_textures',
        'shows_extreme_dislike_to_something',
    ];

    protected $casts = [
        'disturbed_by_physical_contact_with_others' => 'boolean',
        'dislikes_nail_trimming' => 'boolean',
        'fear_in_balance_climbing_games' => 'boolean',
        'excessive_spinning_swinging_games' => 'boolean',
        'passive_when_at_home' => 'boolean',
        'likes_to_be_hugged_and_bought' => 'boolean',
        'puts_fingers_toys_in_mouth' => 'boolean',
        'dislikes_certain_food_textures' => 'boolean',
        'disturbed_by_loud_voices' => 'boolean',
        'likes_to_touch_objects' => 'boolean',
        'disturbed_by_certain_textures' => 'boolean',
        'shows_extreme_dislike_to_something' => 'boolean',
    ];

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
