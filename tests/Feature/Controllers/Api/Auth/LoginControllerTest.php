<?php
declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\Auth;

use App\Models\User;
use Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    /** @test */
    public function it_requires_a_email(): void
    {
        $response = $this->postJson(route('login'));
        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_requires_a_password(): void
    {
        $response = $this->postJson(route('login'));
        $response->assertJsonValidationErrors('password');
    }

    /** @test */
    public function it_returns_errors_if_credentials_dont_match(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'secret'
        ]);
        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function it_returns_a_token_if_credentials_do_match(): void
    {
        User::factory()->create(
            [
                'email' => $email = 'test@test.com',
                'password' => $password = 'password'
            ]
        );
        $response = $this->postJson(route('login'), [
            'email' => $email,
            'password' => $password
        ]);
        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }

    /** @test */
    public function it_returns_a_unauthorized_error_if_email_is_not_verified(): void
    {
        User::factory()->create(
            [
                'email' => $email = 'test@test.com',
                'password' => $password = 'password',
                'email_verified_at' => null
            ]
        );
        $response = $this->postJson(route('login'), [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertJsonFragment(['message' => 'Please confirm your email.']);
    }
}
