<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ObservationQuestion extends Model
{
    use HasFactory;

    protected $table = 'observation_questions';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'question_code',
        'age_category',
        'question_number',
        'question_text',
        'score',
        'is_active',
    ];

    public function observationAnswer(): HasMany
    {
        return $this->hasMany(ObservationAnswer::class, 'question_id', 'id');
    }
}
