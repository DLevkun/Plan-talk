<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $createdAt = $this->faker->dateTimeBetween("-3 months", "-2 month");
        return [
            'title' => $this->faker->word(),
            'group_description' => $this->faker->text(150),
            'category_id' => rand(1,10),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}
