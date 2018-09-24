<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 10)->create();
        foreach(range(1, 10) as $i){
          $faker = new Faker;
          $user = new App\User;
          $user->name = $faker::create()->name;
          $user->email = $faker::create()->safeEmail;
          $user->password = bcrypt('secret');
          $user->confirm_token = str_random(25);
          $user->remember_token = str_random(10);
          $user->save();
          $user->attachRole('user');
        }
    }
}
