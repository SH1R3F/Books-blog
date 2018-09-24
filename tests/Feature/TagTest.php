<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

class TagTest extends TestCase
{

    // Test Creating tag
    public function test_admin_can_create_tag_success_response()
    {
        $faker = new Faker;

        // Create admin user
        $user = new \App\User;
        $user->name = $faker::create()->name;
        $user->email = $faker::create()->unique()->safeEmail;
        $user->password = bcrypt('secret');
        $user->save();
        $user->attachRole('superadministrator');

        $this->actingAs($user)->postJson('/manage/tag', [
            'title' => $faker::create()->name
        ])->assertStatus(201);
    }

    public function test_users_cant_create_tag_failure_response()
    {
        $faker = new Faker;

        // Create normal user
        $user = new \App\User;
        $user->name = $faker::create()->name;
        $user->email = $faker::create()->unique()->safeEmail;
        $user->password = bcrypt('secret');
        $user->save();
        $user->attachRole('user');

        $this->actingAs($user)->postJson('/manage/tag', [
            'title' => $faker::create()->name
        ])->assertStatus(404);
    }


    // Test deleting tag
    public function test_admin_can_delete_tag()
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

        $this->actingAs($user)->delete('/manage/tag/' . $category->id)->assertStatus(200);
    }



}
