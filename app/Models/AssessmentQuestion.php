<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    protected $fillable = [
        'assessment_type',
        'section',
        'filled_by',
        'question_code',
        'question_number',
        'question_text',
        'answer_type',
        'answer_options',
        'is_active',
    ];

    protected $casts = [
        'answer_options' => 'array',
        'answer_format' => 'array',
        'extra_schema' => 'array',
        'is_active' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(AssessmentQuestionGroup::class, 'group_id');
    }

    public function answers()
    {
        return $this->hasMany(AssessmentAnswer::class, 'question_id');
    }
}
