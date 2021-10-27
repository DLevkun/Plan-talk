<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

abstract class TemplateMethod
{
    public function store(){
        $user = Auth::user();
        $post = new Post;
        $post->user_id = $user->id;
        $post->post_image = $this->uploadFile();
        $post->fill($request->all())
            ->save();

        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));

        return redirect('/home')->with('post_success',__('messages.post_created_success'));
    }

    //hook
    public function uploadFile()
    {
    }
}
