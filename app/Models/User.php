<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(
            Listing::class,
            'user_id'
        );
    }

    public function offers(): HasMany
    {
        return $this->hasMany(
            Offer::class,
            'trader_id'
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(
            Review::class,
            'user_id'
        );
    }

    public function reviewed(): HasMany
    {
        return $this->hasMany(
            Review::class,
            'by_user_id'
        );
    }

    public function roomsCreated(): HasMany
    {
        return $this->hasMany(
            ChatRoom::class, 
            'user_one_id'
        );
    }

    public function roomsJoined(): HasMany
    {
        return $this->hasMany(
            ChatRoom::class,
             'user_two_id'
        );
    }
}
