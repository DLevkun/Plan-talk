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
     * @codeCoverageIgnore
     */
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
        return $this->belongsToMany(User::class, 'users_friends', 'user_id', 'friend_id');
    }

    public function groups(){
        return $this->belongsToMany(Group::class)->withPivot('created_at');
    }

    /**
     * @codeCoverageIgnore
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function sendNotification($post_id){
        //if(Cache::store('redis')->has("new_posts_for_$this->id")){
        if (Session::has("new_posts_for_$this->id")){
            //$posts = Cache::store('redis')->get("new_posts_for_$this->id")['posts'];
            $posts = Session::get("new_posts_for_$this->id")['posts'];
        }
        $posts[$post_id] = $post_id;
        Session::put("new_posts_for_$this->id", ['isNew' => true, 'posts' => $posts]);
        //Cache::store('redis')->put("new_posts_for_$this->id", ['isNew' => true, 'posts' => $posts]);
    }
}
