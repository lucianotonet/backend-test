<?php

namespace Tests\Feature\Backstage\Campaigns;

use Tests\TestCase;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function aVisitorCannotSeeTheEditView(): void
    {
        $campaign = create(Campaign::class);

        $response = $this->get(route('backstage.campaigns.edit', $campaign->id));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test */
    public function aUserThatIsNotAnAdminCannotSeeTheCreateView(): void
    {
        $this->signIn();
        $campaign = create(Campaign::class);

        $response = $this->get(route('backstage.campaigns.edit', $campaign->id));
        $response->assertForbidden();
    }

    /** @test */
    public function aAdminUserCanSeeTheEditView(): void
    {
        $this->signInAsAdmin();
        $campaign = create(Campaign::class);

        $response = $this->get(route('backstage.campaigns.edit', $campaign->id));
        $response->assertOk();
    }

    /** @test */
    public function aUserThatIsNotAnAdminCannotModifyACampaign(): void
    {
        $this->signIn();

        $campaign = create(Campaign::class);

        $response = $this->put(route('backstage.campaigns.update', $campaign), $attributes = [
            'name' => $this->faker->userName,
            'timezone' => $this->faker->timezone,
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function anAdminUserCanModifyACampaign(): void
    {
        $this->signInAsAdmin();

        $campaign = create(Campaign::class);

        $response = $this->put(route('backstage.campaigns.update', $campaign), $attributes = [
            'name' => $this->faker->userName,
            'timezone' => $this->faker->timezone,
        ]);

        $this->assertDatabaseHas('campaigns', $attributes);

        $response->assertRedirect(route('backstage.campaigns.edit', $campaign->id));
        $response->assertSessionHas('success', 'The campaign details have been saved!');
    }
}
