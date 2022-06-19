<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostRepository implements Repository
{
    /**
     * Get posts by user
     * @param $user
     * @return mixed
     */
    public function getAllByUser($user){
        $posts = $user->posts()->paginate(10);

        return $posts;
    }

    /**
     * Get one post by its id
     * @param $post_id
     * @return mixed
     */
    public function getOneById($post_id){
        $user = Auth::user();
        $post = $user->posts()->paginate(10)->find($post_id); //Cache::store('redis')->get("auth_user_posts_{$user->id}")->find($post_id);
        return $post;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAll()
    {

    }
}
