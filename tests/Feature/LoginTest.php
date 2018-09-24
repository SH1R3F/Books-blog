<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class LoginTest extends TestCase
{

    public function test_received_msg_on_success_login()
    {
        $user = factory(User::class)->create();
        $user->attachRole('user');
        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'secret' // Correct password
        ])->assertStatus(200)
          ->assertJson([
              'status' => 'success'
          ])
          ->assertSessionHas('success', 'دخول رايق يسبب حرايق يزميلي');
    }

    public function test_received_msg_on_invalid_credentials_login()
    {
        $user = factory(User::class)->create();
        $user->attachRole('user');

        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ])->assertStatus(422)
          ->assertJson([
              'message' => 'البيانات التي أدخلتها لا تتطابق مع سجلاتنا.'
          ]);
    }
}
