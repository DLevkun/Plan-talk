<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->word();
        $createdAt = $this->faker->dateTimeBetween("-3 months", "-2 month");
        return [
            'title' => $title,
            'post_description' => $this->faker->realText(250),
            'post_image' => $this->faker->imageUrl(50,50, $title),
            'category_id' => rand(1,10),
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }
}
