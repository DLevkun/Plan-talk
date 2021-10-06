<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    public static function availableGroups($user_id){
        $result = Group::with('category')->whereNotIn('id', function($query)use($user_id){
            $query->select('group_id')->from('group_user')->where('user_id', '=', $user_id);
        });
        return $result->paginate(10);
    }

    public function getAllGroups($availableGroups)
    {
        Cache::store('redis')->set('all_groups', $availableGroups, new \DateInterval('PT5H'));
        $groups = Cache::store('redis')->get('all_groups');
        return $groups;
    }

    public function getAllByUser($user_id){
        $groups = User::find($user_id)->groups()->paginate(10);
        return $groups;
    }

    public function getOneGroup($id){
        $group = Group::find($id);
        return $group;
    }

    public function unsubscribe($user_id, $id){
        DB::table('group_user')->where('group_id', $id)->where('user_id', $user_id)->delete();
    }
}
