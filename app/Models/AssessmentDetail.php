<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentDetail extends Model
{
    use HasFactory;

    protected $table = 'assessment_details';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'assessment_id',
        'type',
        'admin_id',
        'therapist_id',
        'scheduled_date',
        'status',
        'completed_at',
        'parent_status',
        'parent_completed_at',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    public $timestamps = true;

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
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
