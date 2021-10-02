<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(CategorySeeder::class);
       $this->call(RoleSeeder::class);

        $groups = \App\Models\Group::factory()->count(15)->create();

        for($i = 0; $i < 10; $i++) {
            $users = User::factory(3)->create();
            $user = User::factory()
                ->hasAttached($users)
                ->hasAttached($groups)
                ->create();

            foreach($users as $user){
                $this->createGoals($user);
                $this->createPosts($user);
            }

            $this->createGoals($user);
            $this->createPosts($user);
        }
    }
    public function createGoals($user){
        \App\Models\Goal::factory(10)
            ->for($user)
            ->count(10)
            ->create();
    }

    public function createPosts($user){
        \App\Models\Post::factory(10)
            ->for($user)
            ->count(10)
            ->create();
    }
}
