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
        'name', 'username', 'email', 'group_id', 'phone', 'password', 'role', 'photo', 'created_at', 'updated_at', 'remember_token'
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
        'password' => 'hashed',
    ];

    public function group()
    {
        return $this->belongsTo(UserGroup::class, 'group_id', 'id');
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'created_by');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'created_by');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'created_by');
    }

    public function livetvs()
    {
        return $this->hasMany(LiveTv::class, 'created_by');
    }
}
