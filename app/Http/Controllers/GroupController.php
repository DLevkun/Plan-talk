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
        $this->middleware('auth');
        $this->groupRepository = new GroupRepository();
        $this->categoryRepository = new CategoryRepository();
    }
    /**
     * Display a listing of the groups
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::put('page', $request->input('page') ?? 1);

        $groups = $this->groupRepository->getAllByUser(Auth::user());

        $isAll = true;
        $isAdmin = Session::get('isAdmin');

        return view('group.groups', compact('groups', 'isAll', 'isAdmin'));
    }

    /**
     * Get form for creating group
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        return view('group.create_group', compact('categories'));
    }

    /**
     * Create new group
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

        $availableGroups = $this->groupRepository->getAllByUser(Auth::user());
        Session::put('all_groups', $availableGroups);
        return redirect('/groups')->with('group_success', __('messages.group_create_success'));
    }

    /**
     * Display groups subscribed by user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        Session::put('page', $request->input('page') ?? 1);
        $groups = $this->groupRepository->getAllById($id);
        $isAll = false;
        $isAdmin = false;

        return view('group.groups', compact('groups', 'isAll', 'isAdmin'));
    }


    /**
     * Delete group
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->groupRepository->getOneById($id)->delete();
        $availableGroups = $this->groupRepository->getAllByUser(Auth::user());
        Session::put('all_groups', $availableGroups);

        $page = Session::get('page');

        return redirect("/groups?page={$page}")->with('group_success', __('messages.group_deleted_success'));
    }
}
