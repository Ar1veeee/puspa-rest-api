<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedagogicalVisualImpairmentAspect extends Model
{
    use HasFactory;

    protected $table = 'pedagogical_visual_impairment_aspects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'has_visual_impairment',
        'wearing_glasses',
        'comfortable_reading_while_sitting',
        'comfortable_reading_while_lying_down',
        'daily_gadget_use',
        'gadget_exploration_duration',
    ];

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'visual_impairment_aspect_id');
    }
}
