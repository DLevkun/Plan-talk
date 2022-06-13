<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FriendRepository implements Repository
{
    public function getAllByUser($user){
        //Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT5H"));
        $friends = $user->users; //Cache::store('redis')->get("user_friends_{$user->id}");
        return $friends;
    }

    public function searchPeople($search){
        $result = DB::table('users')
            ->where('id', '<>', Auth::user()->id)
            ->where(function($query)use($search){
                $query->where('full_name', 'like', "%$search%")
                    ->orWhere('nickname', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->get();
        return $result;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getOneById($id)
    {
        // TODO: Implement getOneById() method.
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
