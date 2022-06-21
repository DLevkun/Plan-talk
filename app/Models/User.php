<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Session;

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

    /**
     * User belongs to one role
     * @codeCoverageIgnore
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * User has many goals
     */
    public function goals(){
        return $this->hasMany(Goal::class);
    }

    /**
     * User has many posts
     */
    public function posts(){
        return $this->hasMany(Post::class)->orderBy('created_at', 'desc');
    }

    /**
     * User has many friends
     */
    public function users(){
        return $this->belongsToMany(User::class, 'users_friends', 'user_id', 'friend_id');
    }

    /**
     * User belongs to many groups
     */
    public function groups(){
        return $this->belongsToMany(Group::class)->withPivot('created_at');
    }

    /**
     * User has many comments
     * @codeCoverageIgnore
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

}
