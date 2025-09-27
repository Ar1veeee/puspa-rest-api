<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'families';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    public function guardians(): HasMany
    {
        return $this->hasMany(Guardian::class, 'family_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class, 'family_id', 'id');
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
