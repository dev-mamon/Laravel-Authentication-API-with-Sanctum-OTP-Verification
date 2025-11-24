<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_verified',
        'email_verified_at',
        'verified_at',
        'reset_password_token',
        'reset_password_token_expire_at',
        'dob',
        'phone',
        'avatar',
        'otp',
        'purpose',
        'expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function latestOtp()
    {
        return $this->hasOne(Otp::class)->latestOfMany();
    }

    public function journals()
    {
        return $this->belongsToMany(Journaling::class, 'journal_users', 'user_id', 'journaling_id')
            ->withPivot('is_submitted', 'content')
            ->withTimestamps();
    }

    public function finances()
    {
        return $this->belongsToMany(Finance::class, 'user_finances')
            ->withPivot(['is_submitted', 'allowance', 'expenses', 'save_amount', 'content'])
            ->withTimestamps();
    }
}
