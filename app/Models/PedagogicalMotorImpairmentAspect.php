<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedagogicalMotorImpairmentAspect extends Model
{
    use HasFactory;

    protected $table = 'pedagogical_motor_impairment_aspects';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'has_motor_impairment',
        'motor_impairment_type',
        'motor_impairment_form',
        'has_independent_mobility_difficulty',
        'has_body_part_weakness',
    ];

    public function pedagogicalAssessmentGuardian(): HasOne
    {
        return $this->hasOne(PedagogicalAssessmentGuardian::class, 'motor_impairment_aspect_id');
    }
}
