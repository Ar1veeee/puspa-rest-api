<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioMuscleStrengthExamination extends Model
{
    use HasFactory;

    protected $table = 'physio_muscle_strength_examinations';

    public $timestamps = false;

    protected $fillable = [
        'str_trunk_score',
        'str_aga_dex_score',
        'str_aga_sin_score',
        'str_agb_dex_score',
        'str_agb_sin_score'
    ];
}
