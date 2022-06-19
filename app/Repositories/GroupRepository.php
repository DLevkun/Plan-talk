<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GroupRepository implements Repository
{
    /**
     * Get all groups by user
     * @param $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllByUser($user)
    {
        $user_id = $user->id;
        $result = Group::with('category')->whereNotIn('id', function($query)use($user_id){
            $query->select('group_id')->from('group_user')->where('user_id', '=', $user_id);
        })->paginate(10);

        $groups = $result;
        return $groups;
    }

    /**
     * Get all groups by user
     * @param $user_id
     * @return mixed
     */
    public function getAllById($user_id){
        $groups = User::find($user_id)->groups()->paginate(10);
        return $groups;
    }

    /**
     * Get group by its id
     * @param $id
     * @return mixed
     */
    public function getOneById($id){
        $group = Group::find($id);
        return $group;
    }

    /**
     * Unsubscribe group
     * @param $user_id
     * @param $id
     * @return void
     */
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
