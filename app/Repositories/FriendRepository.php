<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FriendRepository implements Repository
{
    /**
     * Get all friends of user
     * @param $user
     * @return mixed
     */
    public function getAllByUser($user){
        $friends = $user->users;
        return $friends;
    }

    /**
     * Search user by name, nickname or email
     * @param $search
     * @return \Illuminate\Support\Collection
     */
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
