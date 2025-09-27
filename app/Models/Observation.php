<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'therapist_id',
        'scheduled_date',
        'age_category',
        'total_score',
        'conclusion',
        'recommendation',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class, 'child_id', 'id');
    }

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class, 'therapist_id', 'id');
    }
}
