<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalPublishRequest;
use App\Models\Goal;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\GoalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GoalController extends Controller
{
    private $categoryRepository;
    private $goalRepository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->categoryRepository = new CategoryRepository();
        $this->goalRepository = new GoalRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::put('page', $request->input('page') ?? 1);

        $goals = $this->goalRepository->getAllByUser(Auth::user());
        $categories = $this->categoryRepository->getAll();

        $percentDoneGoals = $this->calculatePercentOfDoneGoals();
        $color = $percentDoneGoals == 100 ? '#0cd52c' : '#0d6efd';
        $myPage = true;

        return view('goal.goals', compact('goals', 'categories','percentDoneGoals', 'color', 'myPage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoalPublishRequest $request)
    {
        $user = Auth::user();
        $goal = new Goal;
        $goal->user_id = $user->id;
        $goal->is_done = 0;
        $goal->fill($request->all())
            ->save();

        //Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(10), new \DateInterval('PT5H'));

        return redirect('/goals')->with('goal_success',__('messages.goal_created_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $goals = $this->goalRepository->getAllByUser(User::find($id));
        $myPage = false;

        return view('goal.user_goals', compact('goals', 'myPage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $goal = $this->goalRepository->getOneById($id);
        $categories = $this->categoryRepository->getAll();

        return view('goal.goal_edit', compact('goal', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoalPublishRequest $request, $id)
    {
        $user = Auth::user();
        $goal = $this->goalRepository->getOneById($id);
        $goal->is_done = $request->input('is_done') ? 1 : 0;
        $goal->fill($request->all())->save();

        //Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(10), new \DateInterval('PT5H'));

        $page = Session::get('page');

        return redirect("/goals?page={$page}")->with('goal_success', __('messages.goal_edited_success'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $this->goalRepository->getOneById($id)->delete();

        //Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(10), new \DateInterval('PT5H'));

        $page = Session::get('page');

        return redirect("/goals?page={$page}")->with('goal_success', __('messages.goal_deleted_success'));
    }

    public function calculatePercentOfDoneGoals()
    {
        $all = Auth::user()->goals->count();
        if($all == null){
            return 0;
        }else {
            $done = $this->goalRepository->getDone(Auth::user());
            return round($done * 100 / $all, 1);
        }
    }
}
