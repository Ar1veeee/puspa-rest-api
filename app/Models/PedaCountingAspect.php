<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedaCountingAspect extends Model
{
    use HasFactory;

    protected $table = 'peda_counting_aspects';
    public $timestamps = false;

    protected $fillable = [
        'recognize_numbers_1_10_score',
        'recognize_numbers_1_10_desc',
        'count_concrete_objects_score',
        'count_concrete_objects_desc',
        'compare_quantities_score',
        'compare_quantities_desc',
        'recognize_math_symbols_score',
        'recognize_math_symbols_desc',
        'operate_addition_subtraction_score',
        'operate_addition_subtraction_desc',
        'operate_multiplication_division_score',
        'operate_multiplication_division_desc',
        'use_counting_tools_score',
        'use_counting_tools_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(PedaAssessmentTherapist::class, 'counting_aspect_id');
    }
}
