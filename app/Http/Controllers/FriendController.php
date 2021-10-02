<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendSearchRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ChecksIsDataSecure;

class FriendController extends Controller
{
    use ChecksIsDataSecure;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT5H"));
        $friends = Cache::store('redis')->get("user_friends_{$user->id}");

        return view('friend.friends', compact('friends'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function search(FriendSearchRequest $request)
    {
        $search = $this->getSecureData($request->input('search_field'));
        $friends = DB::table('users')
            ->where('id', '<>', Auth::user()->id)
            ->where(function($query)use($search){
                $query->where('full_name', 'like', "%$search%")
                    ->orWhere('nickname', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->get();
        $myFriends = Auth::user()->users;
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
        $auth_user_id = Auth::id();
        $posts = $user->posts()->paginate(10);
        $categories = Cache::store('redis')->get("all_categories");
        $myFriends = Cache::store('redis')->get("user_friends_{$auth_user_id}");
        $myPage = false;

        return view('home', compact('user', 'posts', 'categories', 'myFriends', 'myPage'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

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

    public function destroySearch($search, $id){
        DB::table('friends_users')
            ->where('friend_id', $id)
            ->where('user_id', Auth::user()->id)
            ->delete();

        $user = Auth::user();
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT2H"));

        return redirect('/friends');
    }

    public function followSearch($search, $id){
        DB::table('friends_users')->insert([
            'user_id' => Auth::user()->id,
            'friend_id' => $id,
        ]);

        $user = Auth::user();
        Cache::store('redis')->set("user_friends_{$user->id}", $user->users, new \DateInterval("PT2H"));

        return redirect('/friends');
    }
}
