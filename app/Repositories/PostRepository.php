<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostRepository implements Repository
{
    public function getAllByUser($user){
        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));
        $posts = Cache::store('redis')->get("auth_user_posts_{$user->id}");

        return $posts;
    }

    public function getOneById($post_id){
        $user = Auth::user();
        $post = Cache::store('redis')->get("auth_user_posts_{$user->id}")->find($post_id);
        return $post;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAll()
    {

    }
}
