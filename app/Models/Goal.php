<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'goal_description',
        'category_id',
    ];

    /**
     * Goal belongs to category
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * Goal belongs to user
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
