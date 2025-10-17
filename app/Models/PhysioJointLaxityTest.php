<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioJointLaxityTest extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['elbow', 'wrist', 'hip', 'knee', 'ankle'];
}
