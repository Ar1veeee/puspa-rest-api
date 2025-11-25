<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestionGroup extends Model
{
    protected $fillable = [
        'assessment_type',
        'group_title',
        'group_key',
        'sort_order',
    ];

    public function questions()
    {
        return $this->hasMany(AssessmentQuestion::class, 'group_id');
    }
}
