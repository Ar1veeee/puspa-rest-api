<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioPlayFunctionTest extends Model
{
    use HasFactory;

    protected $table = 'physio_play_function_tests';

    public $timestamps = false;

    protected $fillable = [
        'play_type', 'follow_object', 'follow_sound', 'reach_object',
        'grasping', 'differentiate_color', 'focus_attention'
    ];
}
