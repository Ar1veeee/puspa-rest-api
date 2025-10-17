<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedaWritingAspect extends Model
{
    use HasFactory;

    protected $table = 'peda_writing_aspects';
    public $timestamps = false;

    protected $fillable = [
        'hold_writing_tool_score',
        'hold_writing_tool_desc',
        'write_straight_down_score',
        'write_straight_down_desc',
        'write_straight_side_score',
        'write_straight_side_desc',
        'write_curved_line_score',
        'write_curved_line_desc',
        'write_letters_straight_score',
        'write_letters_straight_desc',
        'copy_letters_score',
        'copy_letters_desc',
        'write_own_name_score',
        'write_own_name_desc',
        'recognize_and_write_words_score',
        'recognize_and_write_words_desc',
        'write_upper_lower_case_score',
        'write_upper_lower_case_desc',
        'differentiate_similar_letters_score',
        'differentiate_similar_letters_desc',
        'write_simple_sentences_score',
        'write_simple_sentences_desc',
        'write_story_from_picture_score',
        'write_story_from_picture_desc',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(PedaAssessmentTherapist::class, 'writing_aspect_id');
    }
}
