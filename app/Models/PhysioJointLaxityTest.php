<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioJointLaxityTest extends Model
{
    use HasFactory;

    protected $table = 'physio_joint_laxity_tests';

    public $timestamps = false;

    protected $fillable = ['elbow', 'wrist', 'hip', 'knee', 'ankle'];
}
