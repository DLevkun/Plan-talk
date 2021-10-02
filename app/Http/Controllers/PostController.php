<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostPublishRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\UploadsFiles;

class PostController extends Controller
{
    use UploadsFiles;
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostPublishRequest $request)
    {
        $user = Auth::user();
        $post = new Post;
        $post->user_id = $user->id;
        $post->post_image = $this->uploadFile('post', $request, 'post_img', 'postImg');
        $post->fill($request->all())
            ->save();

        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));

        return redirect('/home')->with('post_success',__('messages.post_created_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = Auth::user()->id;
        $post = Cache::store('redis')->get("auth_user_posts_{$user_id}")->find($id);
        $categories = Cache::store('redis')->get("all_categories");
        return view('post_edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostPublishRequest $request, $id)
    {
        $user = Auth::user();
        $post = Cache::store('redis')->get("auth_user_posts_{$user->id}")->find($id);
        $img_path = $this->uploadFile('patch', $request, 'post_img', 'postImg');
        $post->post_image = $img_path ?? $post->post_image;
        $post->fill($request->all())
            ->save();

        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));

        $page = Session::get('page');

        return redirect("home?page={$page}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        Post::find($id)->delete();

        $page = Session::get('page');

        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));

        return redirect("/home?page={$page}");
    }

    public function like(){
        dd(__METHOD__);
    }

    public function showCategoryPosts($id){
        $category = Cache::store('redis')->get("all_categories")->find($id);
        $categoryPosts = $category->posts;
        $title = $category->title;

        return view('category_posts', compact('categoryPosts', 'title'));
    }
}
