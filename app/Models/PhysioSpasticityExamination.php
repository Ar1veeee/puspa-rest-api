<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioSpasticityExamination extends Model
{
    use HasFactory;

    protected $table = 'physio_spasticity_examinations';

    public $timestamps = false;

    protected $fillable = [
        'spas_head_neck_score',
        'spas_trunk_score',
        'spas_aga_dex_score',
        'spas_aga_sin_score',
        'spas_agb_dex_score',
        'spas_agb_sin_score'
    ];
}
