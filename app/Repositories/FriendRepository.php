<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FriendRepository
{
    public function getFriends($user){
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT5H"));
        $friends = Cache::store('redis')->get("user_friends_{$user->id}");
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
}
