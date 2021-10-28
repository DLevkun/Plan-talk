<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendSearchRequest;
use App\Models\Category;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\FriendRepository;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ChecksIsDataSecure;

class FriendController extends Controller
{
    use ChecksIsDataSecure;

    private $friendRepository;
    private $categoryRepository;
    private $postRepository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->categoryRepository = new CategoryRepository();
        $this->friendRepository = new FriendRepository();
        $this->postRepository = new PostRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $friends = $this->friendRepository->getAllByUser($user);

        return view('friend.friends', compact('friends'));
    }


    public function search(FriendSearchRequest $request)
    {
        $search = $this->getSecureData($request->input('search_field'));
        $friends = $this->friendRepository->searchPeople($search);
        $myFriends = $this->friendRepository->getAllByUser(Auth::user());
        return view('friend.friends_search', compact('friends', 'myFriends', 'search'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findorFail($id);
        $posts = $this->postRepository->getAllByUser($user);
        $categories = $this->categoryRepository->getAll();
        $myFriends = $this->friendRepository->getAllByUser(Auth::user());
        $myPage = false;
        $isAdmin = false;

        return view('home', compact('user', 'posts', 'categories', 'myFriends', 'myPage', 'isAdmin'));
    }

    public function follow($id)
    {
        DB::table('friends_users')->insert([
            'user_id' => Auth::user()->id,
            'friend_id' => $id,
        ]);

        $user = Auth::user();
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT2H"));

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('friends_users')
            ->where('friend_id', $id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        $user = Auth::user();
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT2H"));

        return redirect()->back()->withInput();
    }

    public function destroySearch($id)
    {
        DB::table('friends_users')
            ->where('friend_id', $id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        $user = Auth::user();
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT2H"));
        return redirect('/friends');
    }

    public function followSearch($id){
        DB::table('friends_users')->insert([
            'user_id' => Auth::user()->id,
            'friend_id' => $id,
        ]);

        $user = Auth::user();
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT2H"));

        return redirect('/friends');
    }
}
