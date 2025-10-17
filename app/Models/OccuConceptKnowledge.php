<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccuConceptKnowledge extends Model
{
    use HasFactory;

    protected $table = 'occu_concept_knowledges';
    public $timestamps = false;

    protected $fillable = [
        'letter_recognition_pointing_score',
        'letter_recognition_pointing_desc',
        'letter_recognition_reading_score',
        'letter_recognition_reading_desc',
        'letter_recognition_writing_score',
        'letter_recognition_writing_desc',
        'letter_recognition_write_on_board_score',
        'letter_recognition_write_on_board_desc',
        'letter_recognition_write_in_order_score',
        'letter_recognition_write_in_order_desc',
        'color_comprehension_pointing_score',
        'color_comprehension_pointing_desc',
        'color_comprehension_differentiating_score',
        'color_comprehension_differentiating_desc',
        'body_awareness_mentioning_score',
        'body_awareness_mentioning_desc',
        'body_awareness_pointing_score',
        'body_awareness_pointing_desc',
        'time_orientation_day_night_score',
        'time_orientation_day_night_desc',
        'time_orientation_days_score',
        'time_orientation_days_desc',
        'time_orientation_date_month_year_score',
        'time_orientation_date_month_year_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(OccuAssessmentTherapist::class, 'concept_knowledge_id');
    }
}
