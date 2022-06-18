<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Repositories\PostRepository;
use Workerman\Worker;

class HomeController extends Controller
{
    private $postRepository;
    private $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->postRepository = new PostRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        Session::put('isAdmin', ($user->role_id) == 2 ? true : false);
        Session::put('page', $request->input('page') ?? 1);
//        Cache::store('redis')->forget('new_posts_for_45');
//        Cache::store('redis')->forget('new_posts_for_46');
//        Cache::store('redis')->forget('new_posts_for_47');

        $posts = $this->postRepository->getAllByUser($user);
        $categories = $this->categoryRepository->getAll();

        $myPage = true;
        $isAdmin = Session::get('isAdmin');

        return view('home', compact('posts', 'categories', 'user', 'myPage', 'isAdmin'));
    }

    public function data(Request $request){
        $post = new Post;
        $user = Auth::user();
        $post->user_id = $user->id;
        $post->title = $request->input('title');
        $post->post_description = $request->input('descr');
        $post->category_id = 1;
        $post->save();
    }

    public function changeLocale($lang){
        session(['locale' => strtolower($lang)]);
        App::setLocale($lang);
        return redirect()->back();
    }
}
