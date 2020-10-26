<?php
declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
    use RefreshDatabase, MustVerifyEmail;

    /** @test */
    public function it_requires_valid_signature(): void
    {
        $user = User::factory()->create();
        $signature = "?expires=expires&hash=hash&signature=signature";
        $response = $this->getJson("api/auth/email/verify/{$user->id}/{$signature}");
        $response->assertJsonValidationErrors('signature');
    }

    /** @test */
    public function confirm_email_if_is_not_confirmed(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
        $response = $this->getJson($url);
        $response->assertOk();
    }

    /** @test */
    public function email_already_confirmed(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
        $response = $this->getJson($url);
        $response->assertOk();
        $user = User::first();
        self::assertNotNull($user->email_verified_at);
    }
}
