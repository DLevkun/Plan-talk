<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'post_description',
        'category_id',
    ];

    /**
     * Post belongs to users
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Post belongs to category
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * Post belongs to comments
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
