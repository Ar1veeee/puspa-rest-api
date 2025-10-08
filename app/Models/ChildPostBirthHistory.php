<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildPostBirthHistory extends Model
{
    use HasFactory;

    protected $table = 'child_post_birth_histories';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'postbirth_condition',
        'postbirth_condition_duration',
        'postbirth_condition_age',
        'has_ever_fallen',
        'injured_body_part',
        'age_at_fall',
        'other_postbirth_complications',
        'head_lift_age',
        'prone_age',
        'roll_over_age',
        'sitting_age',
        'crawling_age',
        'standing_age',
        'walking_age',
        'complete_immunization',
        'uncompleted_immunization_detail',
        'exclusive_breastfeeding',
        'exclusive_breastfeeding_until_age',
        'rice_intake_age',
    ];

    protected $casts = [
        'has_ever_fallen' => 'boolean',
        'complete_immunization' => 'boolean',
        'exclusive_breastfeeding' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }
}
