<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OccuConcentrationProblemSolving extends Model
{
    use HasFactory;

    protected $table = 'occu_concentration_problem_solvings';

    public $timestamps = false;

    protected $fillable = [
        'concentration_2_commands_score',
        'concentration_2_commands_desc',
        'concentration_3_commands_score',
        'concentration_3_commands_desc',
        'concentration_4_commands_score',
        'concentration_4_commands_desc',
        'concentration_find_in_picture_score',
        'concentration_find_in_picture_desc',
        'problem_solving_puzzle_score',
        'problem_solving_puzzle_desc',
        'problem_solving_story_score',
        'problem_solving_story_desc',
        'size_comprehension_big_small_score',
        'size_comprehension_big_small_desc',
        'size_comprehension_tall_short_score',
        'size_comprehension_tall_short_desc',
        'size_comprehension_many_few_score',
        'size_comprehension_many_few_desc',
        'size_comprehension_long_short_score',
        'size_comprehension_long_short_desc',
        'number_recognition_count_forward_score',
        'number_recognition_count_forward_desc',
        'number_recognition_count_backward_score',
        'number_recognition_count_backward_desc',
        'number_recognition_symbol_score',
        'number_recognition_symbol_desc',
        'number_recognition_concept_score',
        'number_recognition_concept_desc',
    ];

    protected $casts = [
        'concentration_2_commands_score' => 'integer',
        'concentration_3_commands_score' => 'integer',
        'concentration_4_commands_score' => 'integer',
        'concentration_find_in_picture_score' => 'integer',
        'problem_solving_puzzle_score' => 'integer',
        'problem_solving_story_score' => 'integer',
        'size_comprehension_big_small_score' => 'integer',
        'size_comprehension_tall_short_score' => 'integer',
        'size_comprehension_many_few_score' => 'integer',
        'size_comprehension_long_short_score' => 'integer',
        'number_recognition_count_forward_score' => 'integer',
        'number_recognition_count_backward_score' => 'integer',
        'number_recognition_symbol_score' => 'integer',
        'number_recognition_concept_score' => 'integer',
    ];

    public function assessmentTherapist(): HasOne
    {
        return $this->hasOne(OccuAssessmentTherapist::class, 'balance_coordination_id');
    }
}
