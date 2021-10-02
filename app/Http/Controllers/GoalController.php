<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalPublishRequest;
use App\Models\Category;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::put('page', $request->input('page') ?? 1);

        $user = Auth::user();
        Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(5), new \DateInterval('PT5H'));
        $goals = Cache::store('redis')->get("auth_user_goals_{$user->id}");
        $categories = Cache::store('redis')->get("all_categories");

        $percentDoneGoals = $this->calculatePercentOfDoneGoals();
        $color = $percentDoneGoals == 100 ? '#0cd52c' : '#0d6efd';

        return view('goal.goals', compact('goals', 'categories','percentDoneGoals', 'color'));
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
    public function store(GoalPublishRequest $request)
    {
        $user = Auth::user();
        $goal = new Goal;
        $goal->user_id = $user->id;
        $goal->is_done = 0;
        $goal->fill($request->all())
            ->save();

        Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(10), new \DateInterval('PT5H'));

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
        $goals = User::find($id)->goals()->paginate(10);
        return view('goal.user_goals', compact('goals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $goal = Cache::store('redis')->get("auth_user_goals_{$user->id}")->find($id);
        $categories = Cache::store('redis')->get("all_categories");
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
        $goal = Cache::store('redis')->get("auth_user_goals_{$user->id}")->find($id);
        $goal->is_done = $request->input('is_done') ? 1 : 0;
        $goal->fill($request->all())->save();

        Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(10), new \DateInterval('PT5H'));

        $page = Session::get('page');

        return redirect("/goals?page={$page}");
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
        DB::table('goals')->delete($id);
        Cache::store('redis')->set("auth_user_goals_{$user->id}", $user->goals()->paginate(10), new \DateInterval('PT5H'));

        $page = Session::get('page');

        return redirect("/goals?page={$page}");
    }

    public function calculatePercentOfDoneGoals()
    {
        $all = Auth::user()->goals->count();
        if($all == null){
            return 0;
        }else {
            $done = DB::table('goals')
                ->where('user_id', Auth::user()->id)
                ->where('is_done', 1)
                ->count();
            return round($done * 100 / $all, 1);
        }
    }
}
