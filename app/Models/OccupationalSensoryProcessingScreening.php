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

    public function occupationalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(OccupationalAssessmentGuardian::class);
    }
}
