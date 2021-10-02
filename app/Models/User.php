<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'full_name',
        'nickname',
        'email',
        'password',
        'user_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function goals(){
        return $this->hasMany(Goal::class);
    }

    public function posts(){
        return $this->hasMany(Post::class)->orderBy('created_at', 'desc');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'friends_users', 'user_id', 'friend_id');
    }

    public function groups(){
        return $this->belongsToMany(Group::class)->withPivot('created_at');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
