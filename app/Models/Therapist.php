<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Therapist extends Model
{
    use HasUlids;
    use HasFactory;

    protected $table = 'therapists';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'therapist_name',
        'therapist_section',
        'therapist_phone',
        'profile_picture',
    ];

    protected $casts = [
        'therapist_phone' => 'encrypted',
    ];

    protected $touches = ['user'];

    public function observations(): HasMany
    {
        return $this->hasMany(Observation::class, 'therapist_id', 'id');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'therapist_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string)\Symfony\Component\Uid\Ulid::generate();
            }
        });
    }
}
