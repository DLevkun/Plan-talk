<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostPublishRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\UsersFriends;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
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
     * Store a new post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostPublishRequest $request)
    {
        $user = Auth::user();
        $post = new Post;
        $post->user_id = $user->id;
        $post->post_image = $this->uploadFile($request, 'post_img', 'postImg');
        $post->fill($request->all())
            ->save();

        $this->notify($post->id);

        return redirect('/home')->with('post_success',__('messages.post_created_success'));
    }

    /**
     * Show one post
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id){
        $post = Post::find($id);
        $myPage = $post->user_id == Auth::user()->id;
        return view('post.show_one_post', compact('post', 'myPage'));
    }

    /**
     * Show new posts from friends
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showNewPosts(){
        $user = Auth::user();
        $hasNew = (bool) Session::get("new_posts_for_$user->id");
        if($hasNew and Session::get("new_posts_for_$user->id")['isNew']){
            $posts = Session::get("new_posts_for_$user->id")['posts'];
            $newPosts = [];
            foreach($posts as $post){
                $newPosts[] = Post::find($post);
            }
        } else {
            $newPosts = [];
        }

        $myPage = false;

        Session::put("new_posts_for_$user->id", ['isNew' => false, 'posts' => []]);

        return view('post.new_posts', ['posts' => $newPosts, 'myPage' => $myPage]);
    }

    /**
     * Edit post
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->getOneById($id);
        $categories = $this->categoryRepository->getAll();

        return view('post.post_edit', compact('post', 'categories'));
    }

    /**
     * Update post (save edited post)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostPublishRequest $request, $id)
    {
        $post = $this->postRepository->getOneById($id);
        $img_path = $this->uploadFile($request, 'post_img', 'postImg');
        $post->post_image = $img_path == "" ? $post->post_image : null;
        $post->fill($request->all())
            ->save();

        $page = Session::get('page');
        return redirect("/home?page={$page}")->with('post_success', __('messages.post_edited_success'));
    }

    /**
     * Delete post
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $this->postRepository->getOneById($id)->delete();
        $page = Session::get('page');
        $friends = UsersFriends::all()->where("friend_id", $user->id);

        foreach($friends as $friend){
            $friend = User::find($friend->user_id);
            $newPostsForFriend = Session::get("new_posts_for_$friend->id")['posts'];
            unset($newPostsForFriend[$id]);
            Session::put("new_posts_for_$friend->id", ['isNew' => !empty($newPostsForFriend), 'posts' => $newPostsForFriend]);
        }

        return redirect("/home?page={$page}")->with('post_success', __('messages.post_deleted_success'));
    }

    /**
     * Show post by category
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showCategoryPosts($id){
        $category = $this->categoryRepository->getAll()->find($id);
        $categoryPosts = $category->posts;
        $title = $category->title;

        return view('post.category_posts', compact('categoryPosts', 'title'));
    }

    /**
     * Notify users about new post
     * @param $post_id
     * @return void
     */
    public function notify($post_id){
        $user = Auth::user();
        $friends = UsersFriends::all()->where("friend_id", $user->id);
        foreach($friends as $friend){
            $friend = User::find($friend->user_id);
            $friend->sendNotification($post_id);
        }
    }
}
