<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'group_description',
        'category_id'
    ];


    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function users(){
        return $this->belongsToMany(User::class)->withPivot('created_at');
    }
}
