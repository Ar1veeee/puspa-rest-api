<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Observation extends Model
{
    use HasFactory;

    protected $table = 'observations';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'child_id',
        'admin_id',
        'therapist_id',
        'scheduled_date',
        'age_category',
        'total_score',
        'conclusion',
        'recommendation',
        'status',
        'completed_at',
        'is_continued_to_assessment',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'is_continued_to_assessment' => 'boolean',
    ];

    public function observation_answers(): HasMany
    {
        return $this->hasMany(ObservationAnswer::class, 'observation_id', 'id');
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class, 'observation_id', 'id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class, 'child_id', 'id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class, 'therapist_id', 'id');
    }
}
