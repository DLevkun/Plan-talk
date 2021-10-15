<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostPublishRequest;
use App\Models\Post;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\UploadsFiles;

class PostController extends Controller
{
    use UploadsFiles;

    private $categoryRepository;
    private $postRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->postRepository = new PostRepository();
    }
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
        $user = Auth::user();
        $post = $this->postRepository->getOneByUser($user, $id);
        $categories = $this->categoryRepository->getAllCategories();

        return view('post.post_edit', compact('post', 'categories'));
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
        $post = $this->postRepository->getOneByUser($user, $id);
        $img_path = $this->uploadFile('patch', $request, 'post_img', 'postImg');
        $post->post_image = $img_path ?? $post->post_image;
        $post->fill($request->all())
            ->save();

        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));

        $page = Session::get('page');
        return redirect("/home?page={$page}")->with('post_success', __('messages.post_edited_success'));
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
        $this->postRepository->getOneByUser($user, $id)->delete();

        $page = Session::get('page');

        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));

        return redirect("/home?page={$page}")->with('post_success', __('messages.post_deleted_success'));
    }

    public function like(){
    }

    public function showCategoryPosts($id){
        $category = $this->categoryRepository->getAllCategories()->find($id);
        $categoryPosts = $category->posts;
        $title = $category->title;

        return view('post.category_posts', compact('categoryPosts', 'title'));
    }
}
