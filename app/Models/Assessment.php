<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessments';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'observation_id',
        'child_id',
        'report_file',
        'report_uploaded_at',
    ];

    protected $casts = [
        'report_uploaded_at' => 'datetime',
    ];

    public function assessmentDetails(): HasMany
    {
        return $this->hasMany(AssessmentDetail::class, 'assessment_id', 'id');
    }

    public function observation(): BelongsTo
    {
        return $this->belongsTo(ObservationAnswer::class, 'observation_id', 'id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class, 'child_id', 'id');
    }
}
