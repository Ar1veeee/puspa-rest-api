<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildPsychosocialHistory extends Model
{
    use HasFactory;

    protected $table = 'child_psychosocial_histories';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'assessment_id',
        'child_order',
        'siblings',
        'household_members',
        'parent_marriage_status',
        'daily_language',
    ];

    protected $casts = [
        'siblings' => 'array',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class, 'assessment_id', 'id');
    }
}
