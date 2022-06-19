<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Comment has many posts
     * @codeCoverageIgnore
     */
    public function post(){
        return $this->belongsTo(Post::class);
    }

    /**
     * Comment belongs to user
     * @codeCoverageIgnore
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
