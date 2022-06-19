<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GoalRepository implements Repository
{
    /**
     * Get goals by user
     * @param $user
     * @return mixed
     */
    public function getAllByUser($user){
        $goals = $user->goals()->paginate(5);

        return $goals;
    }

    /**
     * Get goal by its id
     * @param $id
     * @return mixed
     */
    public function getOneById($id){
        $user = Auth::user();
        $goals = $user->goals()->paginate(5)->find($id); //Cache::store('redis')->get("auth_user_goals_{$user->id}")->find($id);

        return $goals;
    }

    /**
     * Get done goals
     * @param $user
     * @return int
     */
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
