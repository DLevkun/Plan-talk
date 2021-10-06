<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        Session::put('page', $request->input('page') ?? 1);

        $user = Auth::user();
        $myPage = true;

        Cache::store('redis')->set("auth_user_posts_{$user->id}", $user->posts()->paginate(10), new \DateInterval('PT5H'));
        $posts = Cache::store('redis')->get("auth_user_posts_{$user->id}");
        $categories = Cache::store('redis')->rememberForever("all_categories", function(){
            return Category::all();
        });

        Session::put('isAdmin', ($user->role_id) == 2 ? true : false);
        $isAdmin = Session::get('isAdmin');

        return view('home', compact('posts', 'categories', 'user', 'myPage', 'isAdmin'));
    }

    public function changeLocale($lang){
        session(['locale' => strtolower($lang)]);
        App::setLocale($lang);
        return redirect()->back();
    }
}
