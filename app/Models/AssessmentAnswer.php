<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentAnswer extends Model
{
    protected $fillable = [
        'assessment_detail_id',
        'assessment_id',
        'question_id',
        'type',
        'answer_value',
        'note',
    ];

    protected $casts = [
        'assessment_detail_id' => 'integer',
        'assessment_id' => 'integer',
        'question_id' => 'integer',
        'answer_value' => 'json',
    ];

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class);
    }

    public function assessment()
    {
        return $this->belongsTo(AssessmentDetail::class);
    }
}
