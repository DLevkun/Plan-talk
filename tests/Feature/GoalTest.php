<?php

namespace Tests\Feature;

use App\Http\Controllers\GoalController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class GoalTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;
    private $goalData;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Session::start();
        $this->user = User::factory()->create(['role_id' => 2]);
        $this->actingAs($this->user);
        $this->goalData = [
            '_token' => csrf_token(),
            'title' => 'Title',
            'goal_description' => 'Goal description',
            'category_id' => 1
        ];
    }

    public function testAddGoal(){
        $response = $this->post(route('goals.store'), $this->goalData);

        $response->assertRedirect('goals');
        $response->assertValid();
        $response->assertSessionHas('goal_success');
        $this->assertCount(1, $this->user->goals->all());
    }

    public function testDefaultValueOfIsDone(){
        $this->post(route('goals.store'), $this->goalData);
        $goalIsDone = $this->user->goals->first()->isDone;

        $this->assertEquals(0, $goalIsDone);

    }

    public function testGoalsPage(){
        $response = $this->get('goals');

        $response->assertOk();
        $response->assertViewHas('myPage', true);
        $response->assertSeeText('No goals yet');
    }

    public function testGoalsEditPage(){
        $this->post(route('goals.store'), $this->goalData);
        $goalId = $this->user->goals->first()->id;
        $response = $this->get(route('goals.edit', $goalId));

        $response->assertOk();
        $response->assertViewIs('goal.goal_edit');
    }

    public function testGoalUpdate(){
        $this->get('/home');
        $this->post('goals', $this->goalData);

        $goalId = $this->user->goals->first()->id;

        $response = $this->patch(route('goals.update', $goalId), $this->goalData);
        $response->assertValid();
        $response->assertRedirect('/goals?page=1');
    }

    public function testCalculatePercentOfGoalsNoDone(){
        $this->post(route('goals.store'), $this->goalData);
        $goalController = new GoalController();
        $percent = $goalController->calculatePercentOfDoneGoals();

        $this->assertEquals(0, $percent);
    }

    public function testCalculatePercentOfGoalsAllDone(){
        $this->post(route('goals.store'), $this->goalData);
        $goalId = $this->user->goals->first()->id;

        $this->patch(route('goals.update', $goalId), [
            '_token' => csrf_token(),
            'title' => 'Title',
            'goal_description' => 'Goal description',
            'category_id' => 1,
            'is_done' => 1
        ]);

        $goalController = new GoalController();
        $percent = $goalController->calculatePercentOfDoneGoals();

        $this->assertEquals(100, $percent);
    }

    public function testShowUsersGoals(){
        $response = $this->get(route('goals.show', 1));

        $response->assertOk();
    }

    public function testGoalDelete(){
        $this->get('/home');
        $this->post('goals', $this->goalData);

        $goalId = $this->user->goals->first()->id;

        $response = $this->delete(route('goals.destroy', $goalId), ['_token' => csrf_token()]);

        unset($this->goalData['_token']);
        $this->assertDeleted('goals', $this->goalData);
        $response->assertSessionHas('goal_success');
    }
}
