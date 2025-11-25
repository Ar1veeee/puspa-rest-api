<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentAnswer extends Model
{
    protected $fillable = [
        'assessment_id',
        'question_id',
        'type',
        'answer_value',
        'note',
    ];

    protected $casts = [
        'answer_value' => 'json',
    ];

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
