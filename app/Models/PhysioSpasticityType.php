<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysioSpasticityType extends Model
{
    use HasFactory;

    protected $table = 'physio_spasticity_types';

    public $timestamps = false;

    protected $fillable = ['hemiplegia', 'diplegia', 'quadriplegia', 'monoplegia', 'triplegia'];
}
