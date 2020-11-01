<?php
declare(strict_types=1);

namespace Tests\Feature\Controllers\Api;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fails_if_user_is_not_authenticated(): void
    {
        $response = $this->getJson('/api/companies');
        $response->assertUnauthorized();
    }

    /** @test */
    public function it_returns_a_collection_of_companies(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );
        $company = Company::factory()->create();
        $this->getJson('/api/companies')
            ->assertJsonFragment([
                'name' => $company->name
            ])->assertOk();
    }

    /** @test */
    public function it_adds_new_company(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->postJson('/api/companies', [
            'name' => $name = 'orange.md'
        ])->assertCreated();
        $this->assertDatabaseHas('companies', [
            'name' => $name
        ]);
    }

    /** @test */
    public function it_updates_company_name(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $company = Company::factory()->create();
        $name = 'New company name';
        $this->putJson('/api/companies/' . $company->id, [
            'name' => $name
        ]);
        $this->assertDatabaseHas('companies', [
            'name' => $name
        ]);
    }

    /** @test */
    public function it_shows_one_company_by_id(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $company = Company::factory()->create();
        $response = $this->getJson('/api/companies/' . $company->id);
        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $company->id,
            'name' => $company->name
        ]);
    }

    /** @test */
    public function it_returns_error_if_company_with_this_id_not_found(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->getJson('/api/companies/' . 1);
        $response->assertNotFound();
    }

    /** @test */
    public function it_returns_error_if_try_store_not_unique_name(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );
        $company = Company::factory()->create();
        $response = $this->postJson('/api/companies', [
            'name' => $company->name
        ]);
        $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_deletes_the_company(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );

        $company = Company::factory()->create();
        $response = $this->deleteJson('/api/companies/' . $company->id);
        $response->assertNoContent();
    }
}
