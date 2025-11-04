<?php

namespace App\Models;

use App\Notifications\EmailVerificationNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Symfony\Component\Uid\Ulid;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasUlids;
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'email_verified_at',
        'is_active',
    ];

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    public function therapist(): HasOne
    {
        return $this->hasOne(Therapist::class, 'user_id', 'id');
    }

    public function guardian(): HasOne
    {
        return $this->hasOne(Guardian::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($token, $platform = 'web')
    {
        $this->notify(new ResetPasswordNotification($token, $platform));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Ulid::generate();
            }
        });
    }

    public function getKey()
    {
        return $this->id;
    }
}
