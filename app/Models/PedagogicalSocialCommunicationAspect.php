<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedagogicalSocialCommunicationAspect extends Model
{
    use HasFactory;

    protected $table = 'pedagogical_social_communication_aspects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'child_attitude_when_meeting_new_people',
        'child_attitude_when_meeting_friends',
        'child_often_or_never_initiate_conversations',
        'active_when_speak_to_family',
        'attitude_in_uncomfortable_situations',
        'can_share_toys_food_when_playing',
    ];

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'social_communication_aspect_id');
    }
}
