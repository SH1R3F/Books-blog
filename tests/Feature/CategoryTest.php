<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

class CategoryTest extends TestCase
{
    // Test Creating category
    public function test_admin_can_create_category_success_response()
    {
        $faker = new Faker;

        // Create admin user
        $user = new \App\User;
        $user->name = $faker::create()->name;
        $user->email = $faker::create()->unique()->safeEmail;
        $user->password = bcrypt('secret');
        $user->save();
        $user->attachRole('superadministrator');

        $this->actingAs($user)->postJson('/manage/category', [
            'title' => $faker::create()->name
        ])->assertStatus(201);
    }

    public function test_users_cant_create_category_failure_response()
    {
        $faker = new Faker;

        // Create normal user
        $user = new \App\User;
        $user->name = $faker::create()->name;
        $user->email = $faker::create()->unique()->safeEmail;
        $user->password = bcrypt('secret');
        $user->save();
        $user->attachRole('user');

        $this->actingAs($user)->postJson('/manage/category', [
            'title' => $faker::create()->name
        ])->assertStatus(404);
    }


    // Test deleting category
    public function test_admin_can_delete_category()
    {
        $faker = new Faker;

        // Create category
        $category = new \App\Category;
        $category->title = $faker::create()->word;
        $category->save();

        // Create admin user
        $user = new \App\User;
        $user->name = $faker::create()->name;
        $user->email = $faker::create()->unique()->safeEmail;
        $user->password = bcrypt('secret');
        $user->save();
        $user->attachRole('superadministrator');

        $this->actingAs($user)->delete('/manage/category/' . $category->id)->assertStatus(200);
    }

}
