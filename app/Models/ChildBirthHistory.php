<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildBirthHistory extends Model
{
    use HasFactory;

    protected $table = 'child_birth_histories';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'birth_type',
        'if_normal',
        'caesar_vacuum_reason',
        'crying_immediately',
        'birth_condition',
        'birth_condition_duration',
        'incubator_used',
        'incubator_duration',
        'birth_weight',
        'birth_length',
        'head_circumference',
        'birth_complications_other',
        'postpartum_depression',
    ];

    protected $casts = [
        'crying_immediately' => 'boolean',
        'incubator_used' => 'boolean',
        'postpartum_depression' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }
}
