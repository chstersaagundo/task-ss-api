<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'firstname',
        'lastname',
        'password',
        'email',
        'phone',
        'trial_card',
        'is_verified',
        'verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verified_at' => 'datetime',
        'trial_card' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }
}