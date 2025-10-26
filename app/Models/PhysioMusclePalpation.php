<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioMusclePalpation extends Model
{
    use HasFactory;

    protected $table = 'physio_muscle_palpations';

    public $timestamps = false;

    protected $fillable = [
        'hypertonus_aga_d',
        'hypertonus_aga_s',
        'hypertonus_agb_d',
        'hypertonus_agb_s',
        'hypertonus_perut',
        'hypotonus_aga_d',
        'hypotonus_aga_s',
        'hypotonus_agb_d',
        'hypotonus_agb_s',
        'hypotonus_perut',
        'flyktuatif_aga_d',
        'flyktuatif_aga_s',
        'flyktuatif_agb_d',
        'flyktuatif_agb_s',
        'flyktuatif_perut',
        'normal_aga_d',
        'normal_aga_s',
        'normal_agb_d',
        'normal_agb_s',
        'normal_perut',
    ];
}
