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
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\Uid\Ulid;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasUlids, Notifiable, HasRoles;

    protected $guard_name = 'api';

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password',
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

    protected function getDefaultGuardName(): string
    {
        return 'api';
    }

    public function scopeUnverifiedAdmins($query)
    {
        return $query->with(['admin' => fn($q) => $q->select('id', 'user_id', 'admin_name', 'admin_phone')])
            ->where('is_active', 0)
            ->whereHas('roles', fn($q) => $q->where('name', 'admin'));
    }

    public function scopeUnverifiedTherapists($query)
    {
        return $query->with(['therapist' => fn($q) => $q->select('id', 'user_id', 'therapist_name', 'therapist_phone')])
            ->where('is_active', 0)
            ->whereHas('roles', fn($q) => $q->where('name', 'terapis'));
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
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
