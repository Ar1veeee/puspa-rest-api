<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildEducationHistory extends Model
{
    use HasFactory;

    protected $table = 'child_education_histories';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'currently_in_school',
        'school_location',
        'school_class',
        'long_absence_from_school',
        'long_absence_reason',
        'academic_and_socialization_detail',
        'special_treatment_detail',
        'learning_support_program',
        'learning_support_detail',
    ];

    protected $casts = [
        'currently_in_school' => 'boolean',
        'long_absence_from_school' => 'boolean',
        'learning_support_program' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }
}
