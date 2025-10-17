<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioSystemAnamnesis extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'head_and_neck', 'cardiovascular', 'respiratory', 'gastrointestinal',
        'urogenital', 'musculoskeletal', 'nervous_system', 'sensory', 'motoric'
    ];
}
