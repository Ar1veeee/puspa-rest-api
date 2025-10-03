<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObservationAnswer extends Model
{
    use HasFactory;

    protected $table = 'observation_answers';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'observation_id',
        'question_id',
        'answer',
        'score_earned',
        'note',
    ];

    public function observation(): BelongsTo
    {
        return $this->belongsTo(Observation::class, 'observation_id', 'id');
    }

    public function observation_question(): BelongsTo
    {
        return $this->belongsTo(ObservationQuestion::class, 'question_id', 'id');
    }
}
