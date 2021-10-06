<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::put('page', $request->input('page') ?? 1);

        $availableGroups = Group::availableGroups(Auth::user()->id)->paginate(10);

        Cache::store('redis')->set('all_groups', $availableGroups, new \DateInterval('PT5H'));
        $groups = Cache::store('redis')->get('all_groups');
        $isAll = true;
        $isAdmin = Session::get('isAdmin');

        return view('group.groups', compact('groups', 'isAll', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Cache::store('redis')->get('all_categories');
        return view('group.create_group', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $group = new Group;
        $group
            ->fill($request->all())
            ->save();

        $availableGroups = Group::availableGroups(Auth::user()->id)->paginate(10);
        Cache::store('redis')->set('all_groups', $availableGroups, new \DateInterval('PT5H'));

        return redirect('/groups')->with('group_success', __('messages.group_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        Session::put('page', $request->input('page') ?? 1);
        $groups = User::find($id)->groups()->paginate(10);
        $isAll = false;
        $isAdmin = false;

        return view('group.groups', compact('groups', 'isAll', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::find($id)->delete();
        $availableGroups = Group::availableGroups(Auth::user()->id)->paginate(10);
        Cache::store('redis')->set('all_groups', $availableGroups, new \DateInterval('PT5H'));

        $page = Session::get('page');

        return redirect("/groups?page={$page}");
    }
}
