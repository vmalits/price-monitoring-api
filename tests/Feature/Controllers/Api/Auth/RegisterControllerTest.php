<?php

namespace Tests\Feature\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_requires_a_name(): void
    {
        $response = $this->postJson(route('register'));
        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function min_name_length_must_be_two_characters(): void
    {
        $response = $this->postJson(route('register'),[
            'name' => 'q'
        ]);
        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function max_name_length_must_be_thirty_characters(): void
    {
        $response = $this->postJson(route('register'),[
            'name' => $this->faker->sentence(31)
        ]);
        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_email(): void
    {
        $response = $this->postJson(route('register'));
        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_a_valid_email(): void
    {
        $response = $this->postJson(route('register'), [
            'email' => 'some text'
        ]);
        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_a_unique_email(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('register'), [
            'email' => $user->email
        ]);
        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_a_password(): void
    {
        $response = $this->postJson(route('register'));
        $response->assertJsonValidationErrors('password');
    }

    /** @test */
    public function min_password_length_must_be_eight_characters(): void
    {
        $response = $this->postJson(route('register'),[
            'password' => $this->faker->password(3)
        ]);
        $response->assertJsonValidationErrors('password');
    }

    /** @test */
    public function max_password_length_must_be_thirty_characters(): void
    {
        $response = $this->postJson(route('register'),[
            'password' => $this->faker->password(31)
        ]);
        $response->assertJsonValidationErrors('password');
    }

    /** @test */
    public function it_registers_a_user(): void
    {
        $this->postJson(route('register'), [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password(8),
            'password_confirmation' => $password,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }

    /** @test */
    public function a_confirmation_email_is_send_upon_registration(): void
    {
        \Notification::fake();
        $this->postJson(route('register'), [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password(8),
            'password_confirmation' => $password,
        ]);
        $user = User::first();
        \Notification::assertSentTo($user, VerifyEmail::class);
    }
}
