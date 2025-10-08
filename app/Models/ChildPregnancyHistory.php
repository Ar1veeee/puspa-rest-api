<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildPregnancyHistory extends Model
{
    use HasFactory;

    protected $table = 'child_pregnancy_histories';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'pregnancy_desired',
        'routine_checkup',
        'mother_age_at_pregnancy',
        'pregnancy_duration',
        'pregnancy_hemoglobin',
        'pregnancy_incidents',
        'medication_consumption',
        'pregnancy_complications',
    ];

    protected $casts = [
        'pregnancy_desired' => 'boolean',
        'routine_checkup' => 'boolean',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }
}
