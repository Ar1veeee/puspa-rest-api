<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guardian extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'guardians';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'family_id',
        'user_id',
        'temp_email',
        'guardian_type',
        'guardian_name',
        'guardian_phone',
        'guardian_birth_date',
        'guardian_occupation',
        'relationship_with_child',
        'profile_picture',
    ];

    protected $casts = [
        'guardian_birth_date' => 'date',
        'guardian_phone' => 'encrypted',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id', 'id');
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
                $model->id = (string) \Symfony\Component\Uid\Ulid::generate();
            }
        });
    }
}
