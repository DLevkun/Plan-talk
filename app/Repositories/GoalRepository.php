<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GoalRepository implements Repository
{
    public function getAllByUser($user){
        Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(5), new \DateInterval('PT5H'));
        $goals = Cache::store('redis')->get("auth_user_goals_{$user->id}");

        return $goals;
    }

    public function getOneById($id){
        $user = Auth::user();
        $goals = Cache::store('redis')->get("auth_user_goals_{$user->id}")->find($id);

        return $goals;
    }

    public function getDone($user){
        $result = DB::table('goals')
            ->where('user_id', $user->id)
            ->where('is_done', 1)
            ->count();
        return $result;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
