<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioSpasticityType extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['hemiplegia', 'diplegia', 'quadriplegia', 'monoplegia', 'triplegia'];
}
