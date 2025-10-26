<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioSensoryExamination extends Model
{
    use HasFactory;

    protected $table = 'physio_sensory_examinations';

    public $timestamps = false;

    protected $fillable = [
        'visual', 'auditory', 'olfactory', 'gustatory', 'tactile',
        'proprioceptive', 'vestibular'
    ];
}
