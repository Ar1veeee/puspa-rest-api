<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioPhysiotherapyDiagnosis extends Model
{
    use HasFactory;

    protected $table = 'physio_physiotherapy_diagnoses';

    public $timestamps = false;

    protected $fillable = [
        'impairments',
        'functional_limitations',
        'participant_restrictions',
    ];

    protected $casts = [
        'impairments' => 'array',
        'functional_limitations' => 'array',
        'participant_restrictions' => 'array',
    ];
}
