<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessments';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'child_id',
        'therapist_id',
        'scheduled_date',
        'status',
        'fisio',
        'wicara',
        'paedagog',
        'okupasi',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'fisio' => 'boolean',
        'wicara' => 'boolean',
        'paedagog' => 'boolean',
        'okupasi' => 'boolean',
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
