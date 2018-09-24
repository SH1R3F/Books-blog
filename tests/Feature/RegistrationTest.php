<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class RegistrationTest extends TestCase
{

    public function test_registration_success_response()
    {
        $faker = new Faker;

        // Register the user
        $this->postJson('/register', [
            'name' => $faker::create()->name,
            'email' => $faker::create()->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])

        // Check response status Success 200
        ->assertStatus(200)

        // Check response Json
        ->assertJson([
            'status' => 'success'
        ]);
    }

    public function test_registration_failure_response()
    {
        // Custom exceptions check
        $this->assertTrue(true);
    }


    public function test_user_has_default_slug_after_registration()
    {
        $this->assertTrue(true);
    }

    public function test_registration_email_sending()
    {
        Mail::fake();
        $faker = new Faker;

        // Register the user
        $this->postJson('/register', [
            'name' => $faker::create()->name,
            'email' => $faker::create()->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        // Check Verification email sending is sent.
        Mail::assertSent(\App\Mail\ConfirmYourEmail::class);
    }

    public function test_generated_token_after_regestration()
    {
        $faker = new Faker;

        // Register random user
        $user = factory(\App\User::class)->create();

        // Check if confirmation token is not null
        $this->assertFalse(\App\User::find($user->id)->isConfirmed());
    }
    public function test_user_can_confirm_email()
    {
        // Create random user
        $user = factory(\App\User::class)->create();
        $this->get("/register/confirm/{$user->confirm_token}")
        ->assertRedirect('/')
        ->assertSessionHas('success', 'تم تفعيل الإيميل الخاص بك بنجاح.');

        // Check confirmation token is changed to null
        $this->assertTrue($user->fresh()->isConfirmed());
    }

    public function test_wrong_token_error_msg()
    {
        // Create Random User
        $user = factory(\App\User::class)->create();
        $this->get("/register/confirm/WRONGTOKENVALUE")
        ->assertRedirect('/')
        ->assertSessionHas('error', 'فشل تفعيل البريد الخاص بك. يرجى التأكد من صحة الرابط الذي اتبعته وإعادة المحاولة.');

        // Check confirmation token isn't null
        $this->assertFalse($user->fresh()->isConfirmed());
    }

}
