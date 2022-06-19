<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Category has many goals
     * @codeCoverageIgnore
     */
    public function goals(){
        return $this->hasMany(Goal::class);
    }

    /**
     * Category has many posts
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    /**
     * Category has many groups
     * @codeCoverageIgnore
     */
    public function groups(){
        return $this->hasMany(Group::class);
    }
}
