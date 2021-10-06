<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\PostRepository;

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

        $posts = $this->postRepository->getAllByUser($user);
        $categories = $this->categoryRepository->getAllCategories();

        $myPage = true;
        $isAdmin = Session::get('isAdmin');

        return view('home', compact('posts', 'categories', 'user', 'myPage', 'isAdmin'));
    }

    public function changeLocale($lang){
        session(['locale' => strtolower($lang)]);
        App::setLocale($lang);
        return redirect()->back();
    }
}
