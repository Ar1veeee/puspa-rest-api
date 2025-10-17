<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioMuscleStrengthExamination extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'trunk_score', 'aga_dex_score', 'aga_sin_score', 'agb_dex_score', 'agb_sin_score'
    ];
}
