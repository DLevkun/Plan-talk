<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * @codeCoverageIgnore
     */
    public function goals(){
        return $this->hasMany(Goal::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function groups(){
        return $this->hasMany(Group::class);
    }
}
