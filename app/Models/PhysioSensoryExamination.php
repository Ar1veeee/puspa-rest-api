<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioSensoryExamination extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'visual', 'auditory', 'olfactory', 'gustatory', 'tactile',
        'proprioceptive', 'vestibular'
    ];
}
