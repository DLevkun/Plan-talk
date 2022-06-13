<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GroupRepository implements Repository
{
//    public static function availableGroups($user_id){
//        $result = Group::with('category')->whereNotIn('id', function($query)use($user_id){
//            $query->select('group_id')->from('group_user')->where('user_id', '=', $user_id);
//        });
//        return $result->paginate(10);
//    }

    public function getAllByUser($user)
    {
        $user_id = $user->id;
        $result = Group::with('category')->whereNotIn('id', function($query)use($user_id){
            $query->select('group_id')->from('group_user')->where('user_id', '=', $user_id);
        })->paginate(10);

        //Cache::store('redis')->set('all_groups', $result, new \DateInterval('PT5H'));
        $groups = $result; //Cache::store('redis')->get('all_groups');
        return $groups;
    }

    public function getAllById($user_id){
        $groups = User::find($user_id)->groups()->paginate(10);
        return $groups;
    }

    public function getOneById($id){
        $group = Group::find($id);
        return $group;
    }

    public function unsubscribe($user_id, $id){
        DB::table('group_user')->where('group_id', $id)->where('user_id', $user_id)->delete();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
