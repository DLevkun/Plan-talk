<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$nickname = $this->faker->userName();
        $nickname = $this->faker->name();
        $createdAt = $this->faker->dateTimeBetween("-3 months", "-2 month");
        return [
            'full_name' => $this->faker->name(),
            'nickname' => $nickname,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(),
            'remember_token' => Str::random(10),
            'user_image' => $this->faker->imageUrl(50,50, $nickname),
            'role_id' => (rand(1,4) == 4) ? 2 : 1,
            'created_at' => $createdAt,
            'updated_at' => $createdAt
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
