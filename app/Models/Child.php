<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Child extends Model
{
    use HasFactory;
    use HasUlids;

    protected $table = 'children';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'family_id',
        'child_name',
        'child_birth_place',
        'child_birth_date',
        'child_address',
        'child_complaint',
        'child_school',
        'child_service_choice',
        'child_religion',
    ];

    protected $casts = [
        'child_birth_date' => 'date',
        'child_address' => 'encrypted',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id', 'id');
    }

    public function observation(): HasOne
    {
        return $this->hasOne(Observation::class, 'child_id', 'id');
    }

    public static function calculateAgeAndCategory(string $birthDate): array
    {
        $age = Carbon::parse($birthDate)->age;

        $category = match (true) {
            $age <= 5 => 'balita',
            $age <= 12 => 'anak-anak',
            $age <= 17 => 'remaja',
            default => 'lainya',
        };

        return [
            'age' => $age,
            'category' => $category,
        ];
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
