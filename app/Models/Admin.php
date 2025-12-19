<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    use HasUlids;
    use HasFactory;

    protected $guard_name = 'api';
    
    protected $table = 'admins';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'admin_name',
        'admin_phone',
        'admin_birth_date',
        'profile_picture',
    ];

    protected $casts = [
        'admin_phone' => 'encrypted',
        'admin_birth_date' => 'date',
    ];

    protected $touches = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function observations(): HasMany
    {
        return $this->hasMany(Assessment::class, 'admin_id', 'id');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'admin_id', 'id');
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
