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

//    public static function availableGroups($user_id){
//        $result = Group::with('category')->whereNotIn('id', function($query)use($user_id){
//            $query->select('group_id')->from('group_user')->where('user_id', '=', $user_id);
//        });
//        return $result;
//    }


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('created_at');
    }
}
