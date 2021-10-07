<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    private $groupRepository;
    private $categoryRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
        $this->categoryRepository = new CategoryRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::put('page', $request->input('page') ?? 1);

        $availableGroups = $this->groupRepository->availableGroups(Auth::user()->id);
        $groups = $this->groupRepository->getAllGroups($availableGroups);

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
        $categories = $this->categoryRepository->getAllCategories();
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

        $availableGroups = $this->groupRepository->availableGroups(Auth::user()->id);
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
        $groups = $this->groupRepository->getAllByUser($id);
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
        $this->groupRepository->getOneGroup($id)->delete();
        $availableGroups = $this->groupRepository->availableGroups(Auth::user()->id);
        Cache::store('redis')->set('all_groups', $availableGroups, new \DateInterval('PT5H'));

        $page = Session::get('page');

        return redirect("/groups?page={$page}")->with('group_success', __('messages.group_deleted_success'));
    }
}
