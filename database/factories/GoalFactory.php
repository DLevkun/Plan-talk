<?php

namespace Database\Factories;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Goal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $createdAt = $this->faker->dateTimeBetween("-3 months", "-2 month");
        $isDone = rand(0,3) > 1;
        return [
            'title' => $this->faker->word(),
            'goal_description' => $this->faker->paragraph(),
            'is_done' => $isDone,
            'category_id' => rand(1,10),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}
