<?php
declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_fails_if_user_is_not_authenticated(): void
    {
        $response = $this->getJson(route('roles.index'));
        $response->assertUnauthorized();
    }

    /** @test */
    public function it_returns_a_collection_of_roles(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );
        $role = Role::factory()->create();
        $this->getJson(route('roles.index'))
            ->assertJsonFragment([
                'name' => $role->name
            ])->assertOk();
    }

    /** @test */
    public function it_adds_new_role(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $newRole = Role::factory()->make();
        $this->postJson(route('roles.store'), $newRole->toArray())
            ->assertCreated();
        $this->assertDatabaseHas('roles', $newRole->toArray());
    }

    /** @test */
    public function it_updates_role(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $role = Role::factory()->create();
        $updatedRoleData = Company::factory()->make();
        $this->putJson('/api/roles/' . $role->id, $updatedRoleData->toArray());
        $this->assertDatabaseHas('roles', [
            'name' => $updatedRoleData->name
        ]);
    }


    /** @test */
    public function it_shows_one_role_by_id(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $role = Role::factory()->create();
        $response = $this->getJson('/api/roles/' . $role->id);
        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $role->id,
            'name' => $role->name
        ]);
    }

    /** @test */
    public function it_returns_error_if_role_with_this_id_not_found(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->getJson('/api/roles/' . 1);
        $response->assertNotFound();
    }

    /** @test */
    public function it_deletes_the_company(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $role = Role::factory()->create();
        $response = $this->deleteJson('/api/roles/' . $role->id);
        $response->assertNoContent();
    }
}
