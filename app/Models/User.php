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
        'name',
        'email',
        'password',
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
        'email_verified_at' => 'datetime',
    ];

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    public function getIsVerifiedAttribute()
    {
        return $this->getSumOfLikes() >= 10000;
    }

    private function getSumOfLikes()
    {
        return $this->getTweets()->sum(function ($tweet) {
            return $tweet->likes->count();
        });
    }

    public function getTweetsCountAttribute()
    {
        return $this->getTweets()->count();
    }

    private function getTweets()
    {
        return $this->tweets ?? $this->tweets();
    }

    public function likes()
    {
        return $this->belongsToMany(Tweet::class, 'likes');
    }
}
