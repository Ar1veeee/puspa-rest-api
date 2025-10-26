<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioGeneralExamination extends Model
{
    use HasFactory;

    protected $table = 'physio_general_examinations';

    public $timestamps = false;

    protected $fillable = [
        'arrival_method',
        'consciousness',
        'cooperation',
        'blood_pressure',
        'pulse',
        'respiratory_rate',
        'nutritional_status',
        'temperature',
        'head_circumference'
    ];
}
