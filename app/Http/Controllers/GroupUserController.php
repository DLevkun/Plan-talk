<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GroupUserController extends Controller
{
    private $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        DB::table('group_user')->insert([
            'user_id' => Auth::user()->id,
            'group_id' => $id,
        ]);
        $page = Session::get('page');

        return redirect("/groups?page={$page}");
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


    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $this->groupRepository->unsubscribe($user_id, $id);
        $page = Session::get('page');

        return redirect("/groups/{$user_id}?page={$page}");
    }
}
